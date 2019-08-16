<?php

namespace App\Http\Controllers;

use App\Models\Approval;
use Illuminate\Http\Request;

class ApprovalControllerNew extends Controller
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
            $searchResults = Approval::where('user_id', 'like', '%'.$request->input('cid').'%')->take(10);
        } elseif ($request->has('name')) {
            $request->validate([
                'name' => 'string',
            ]);
            $searchString = $request->input('name');
            $searchResults = Approval::whereHas('user', function ($query) use ($searchString){
                $query->where('name_first', 'like', '%'.$searchString.'%')->orWhere('name_last', 'like', '%'.$searchString.'%');
            })->take(10);
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Approval  $approval
     * @return \Illuminate\Http\Response
     */
    public function show(Approval $approval)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Approval  $approval
     * @return \Illuminate\Http\Response
     */
    public function edit(Approval $approval)
    {
        //
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
        //
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
