<?php

namespace App\Http\Controllers\Admin;

use App\Models\Approval;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\AfvApiController;

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
        if ($request->has('cid')) {
            $request->validate([
                'cid' => 'integer|min:0|max:1500000',
            ]);
            $searchResults = Approval::where('user_id', 'like', '%'.$request->input('cid').'%')->where('user_id', '!=', auth()->user()->id);
        } elseif ($request->has('name')) {
            $request->validate([
                'name' => 'string',
            ]);
            $searchString = $request->input('name');
            $searchResults = Approval::whereHas('user', function ($query) use ($searchString) {
                $query->where('name_first', 'like', '%'.$searchString.'%')->orWhere('name_last', 'like', '%'.$searchString.'%');
            })->where('user_id', '!=', auth()->user()->id);
        } else {
            return redirect()->back();
        }

        return view('sections.approvals.search_results')->withSearchResults($searchResults);
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

        $newApprovals = Approval::pending()->inRandomOrder()->take($request->input('qty'));
        $approved = 0;

        foreach ($newApprovals->cursor() as $approval) {
            try {
                $requestData = ['Username' => (string) $approval->user_id, 'Enabled' => true];
                AfvApiController::doPUT('users/enabled', [$requestData]);
            } catch (\Exception $e) {
                continue;
            }
            $approval->setAsApproved();
            $approved++;
        }

        return redirect()->route('approvals.index')->withSuccess(['Done!', "$approved users have been approved :)"]);
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

        foreach ($newApprovals->cursor() as $approval) {
            try {
                $requestData = ['Username' => (string) $approval->user_id, 'Enabled' => true];
                AfvApiController::doPUT('users/enabled', [$requestData]);
            } catch (\Exception $e) {
                continue;
            }
            $approval->setAsApproved();
        }

        return redirect()->back()->withSuccess(['Done!', 'All users have been approved :)']);
    }

    /**
     * Reset approval's availabilities.
     *
     * @return \Illuminate\Http\Response
     */
    public function resetAvailable()
    {
        Approval::available()->update(['available_for_next_event' => null]);

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
            if ($approval->banned) {
                return redirect()->route('approvals.edit', ['approval' => $approval])->withError(['User is banned', 'This user can\'t be granted access to the beta']);
            }
            $data = ['Username' => (string) $approval->user_id, 'Enabled' => true];
            try {
                AfvApiController::doPUT('users/enabled', [$data]);
                $approval->setAsApproved();
                if ($approval->user) {
                    return redirect()->route('approvals.edit', ['approval' => $approval])->withSuccess(['Ta Daaaa!', 'User approved']);
                } else {
                    return redirect()->route('approvals.edit', ['approval' => $approval])->withWarn(['Approved', 'User won\'t receive an email (not registered)']);
                }
            } catch (\Exception $e) {
                return redirect()->route('approvals.edit', ['approval' => $approval])->withError([$e->getCode(), 'AFV Server replied with '.$e->getMessage()]);
            }
        } else {
            $data = ['Username' => (string) $approval->user_id, 'Enabled' => false];
            try {
                AfvApiController::doPUT('users/enabled', [$data]);
                $approval->setAsPending();

                return redirect()->route('approvals.edit', ['approval' => $approval])->withSuccess(['Woosh!', 'User approval revoked']);
            } catch (\Exception $e) {
                return redirect()->route('approvals.edit', ['approval' => $approval])->withError([$e->getCode(), 'AFV Server replied with '.$e->getMessage()]);
            }
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
