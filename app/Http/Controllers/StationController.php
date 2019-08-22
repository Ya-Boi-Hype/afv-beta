<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class StationController extends Controller
{
    protected static $resultsPerPage = 15;

    /**
     * Performs a search for the given parameters.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $request->validate([
            'search' => 'present',
            'page' => 'nullable|integer',
        ]);
        $search = ($request->input('search')) ?? ''; // Because 'convertEmptyStringstoNull' middleware made API return 500
        $search = strtoupper($search);
        $currentPage = ($request->input('page')) ?? 1;
        $data = ['searchText' => $search, 'skip' => self::$resultsPerPage * ($currentPage - 1), 'take' => self::$resultsPerPage];

        try {
            $searchResults = AfvApiController::doPOST('stations/search', $data);
        } catch (\Exception $e) {
            return redirect()->back()->withError(['Poopsie - '.$e->getCode(), 'Server response: '.$e->getMessage()])->withInput();
        }

        $data = json_decode($searchResults);

        $searchResults = new LengthAwarePaginator(
            $data->stations,
            $data->total,
            self::$resultsPerPage,
            $currentPage,
            [
                'path'=>route('stations.index'),
                'query' => ['search' => $search],
            ]
        );

        return view('sections.stations.search_results', compact('searchResults'));
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('search')) {
            return $this->search($request);
        }

        return view('sections.stations.index');
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
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $searchFor = rawurlencode($id);
            $response = AfvApiController::doGET("stations/$searchFor");
        } catch (\Exception $e) {
            if ($e->getCode() == 404) {
                abort(404);
            } else {
                return redirect()->back()->withError([$e->getCode(), 'Server response: '.$e->getMessage()]);
            }
        }

        $station = json_decode($response);

        echo '<pre>';
        print_r($station);
        echo '</pre>';
        die();

        return view('sections.transceivers.show', compact('station'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
