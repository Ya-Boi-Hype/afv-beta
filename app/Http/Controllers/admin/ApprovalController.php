<?php

namespace App\Http\Controllers\Admin;

use App\Models\Approval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class ApprovalController extends Controller
{
    /**
     * Performs a search for the given parameters.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    private function search(Request $request)
    {
        if ($request->has('cid')) { // Search by CID
            $request->validate(['cid' => 'integer|min:0|max:1500000']);
            $searchResults = Approval::where('user_id', 'like', '%'.$request->input('cid').'%')->where('user_id', '!=', auth()->user()->id);
        } else { // Search by name
            $request->validate(['name' => 'string']);
            $searchString = $request->input('name');
            $searchResults = Approval::whereHas('user', function ($query) use ($searchString) {
                $query->where('name_first', 'like', '%'.$searchString.'%')->orWhere('name_last', 'like', '%'.$searchString.'%');
            })->where('user_id', '!=', auth()->user()->id);
        }

        return view('sections.approvals.search_results', compact('searchResults'));
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('cid') || $request->has('name')) {
            return $this->search($request);
        }

        $approved = Approval::approved()->count();
        $pending = Approval::pending()->count();
        $total = $approved + $pending;

        return view('sections.approvals.index', compact('total', 'approved', 'pending'));
    }

    /**
     * Approve n random users.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function random(Request $request)
    {
        $request->validate([
            'qty' => 'required|integer|min:0',
        ]);

        $qty = $request->input('qty');
        $newApprovals = Approval::pending()->inRandomOrder()->take($qty);
        $approved = 0;

        Log::info(auth()->user()->full_name.' ('.auth()->user()->id.") is approving $qty random users");
        foreach ($newApprovals->cursor() as $approval) {
            try {
                $approval->approve();
            } catch (\Exception $e) {
                continue;
            }
            $approved++;
            if ($approval->user) {
                Log::info($approval->user->full_name.' ('.$approval->user->id.') approved');
            } else {
                Log::info($approval->user_id.' approved');
            }
        }
        Log::info(auth()->user()->full_name.' ('.auth()->user()->id.") has approved $approved random users successfully");

        return redirect()->route('approvals.index')->withSuccess(['Done!', "$approved users have been approved"]);
    }

    /**
     * Display the approvals that have expressed availability.
     *
     * @return \Illuminate\Http\Response
     */
    public function availabilities()
    {
        $searchResults = Approval::available()->where('user_id', '!=', auth()->user()->id);

        return view('sections.approvals.search_results', compact('searchResults'));
    }

    /**
     * Approves all approvals with availability for an event.
     */
    public function approveAvailable()
    {
        $newApprovals = Approval::available()->where('approved_at', null);
        $approved = 0;

        Log::info(auth()->user()->full_name.' ('.auth()->user()->id.') is approving all available users');
        foreach ($newApprovals->cursor() as $approval) {
            try {
                $approval->approve();
            } catch (\Exception $e) {
                continue;
            }
            $approved++;
            if ($approval->user) {
                Log::info($approval->user->full_name.' ('.$approval->user->id.') approved');
            } else {
                Log::info($approval->user_id.' approved');
            }
        }
        Log::info(auth()->user()->full_name.' ('.auth()->user()->id.") has approved $approved users successfully");

        return redirect()->back()->withSuccess(['Done!', "$approved users have been approved"]);
    }

    /**
     * Reset approval's availabilities.
     *
     * @return \Illuminate\Http\Response
     */
    public function resetAvailable()
    {
        Approval::available()->update(['available_for_next_event' => null]);
        Log::info(auth()->user()->full_name.' ('.auth()->user()->id.') has reseted event availabilities');

        return redirect()->route('approvals.index')->withSuccess(['Done!', 'All availabilities have been reset']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Approval  $approval
     * @return \Illuminate\Http\Response
     */
    public function edit(Approval $approval)
    {
        return view('sections.approvals.edit', compact('approval'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Approval  $approval
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Approval $approval)
    {
        $request->validate([
            'action' => 'string|in:approve,revoke',
        ]);

        if ($request->input('action') == 'approve') {
            try {
                $approval->approve();
            } catch (\Exception $e) {
                if ($e->getCode() == 0) {
                    return redirect()->route('approvals.edit', ['approval' => $approval])->withError(['Error', $e->getMessage()]);
                } else {
                    return redirect()->route('approvals.edit', ['approval' => $approval])->withError([$e->getCode(), 'AFV Server replied with '.$e->getMessage()]);
                }
            }

            if ($approval->user) {
                Log::info(auth()->user()->full_name.' ('.auth()->user()->id.') has approved '.$approval->user->full_name.' ('.$approval->user->id.')');
            } else {
                Log::info(auth()->user()->full_name.' ('.auth()->user()->id.') has approved '.$approval->user->id);
            }

            return redirect()->route('approvals.edit', ['approval' => $approval])->withSuccess(['Approved!', 'User now has access to the beta']);
        } else {
            try {
                $approval->revoke();
            } catch (\Exception $e) {
                return redirect()->route('approvals.edit', ['approval' => $approval])->withError([$e->getCode(), 'AFV Server replied with '.$e->getMessage()]);
            }

            if ($approval->user) {
                Log::info(auth()->user()->full_name.' ('.auth()->user()->id.') has revoked '.$approval->user->full_name.' ('.$approval->user->id.')');
            } else {
                Log::info(auth()->user()->full_name.' ('.auth()->user()->id.') has revoked '.$approval->user->id);
            }

            return redirect()->route('approvals.edit', ['approval' => $approval])->withSuccess(['Gone with the wind', 'User approval has been revoked']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Approval  $approval
     * @return \Illuminate\Http\Response
     */
    public function destroy(Approval $approval)
    {
        //
    }
}
