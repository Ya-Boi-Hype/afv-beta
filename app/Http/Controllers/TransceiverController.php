<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class TransceiverController extends Controller
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
            $searchResults = AfvApiController::doPOST('stations/transceivers/search', $data);
        } catch (\Exception $e) {
            return redirect()->back()->withError(['Poopsie - '.$e->getCode(), 'Server response: '.$e->getMessage()])->withInput();
        }

        $data = json_decode($searchResults);

        $searchResults = new LengthAwarePaginator(
            $data->transceivers,
            $data->total,
            self::$resultsPerPage,
            $currentPage,
            [
                'path'=>route('transceivers.index'),
                'query' => ['search' => $search],
            ]
        );
        
        return view('sections.transceivers.search_results', compact('searchResults'));
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

        return view('sections.transceivers.index');
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
        $request->validate([
            'lat' => 'required|numeric|max:90|min:-90',
            'lon' => 'required|numeric|max:180|min:-180',
            'name' => 'required|string|regex:/^[a-zA-Z0-9_]+$/',
            'alt_msl' => 'required|integer|min:0',
            'alt_agl' => 'required|integer|min:0',
        ]);

        try {
            $response = AfvApiController::doPOST('stations/transceivers', [
                'Name' => strtoupper($request->input('name')),
                'LatDeg' => $request->input('lat'),
                'LonDeg' => $request->input('lon'),
                'AltMslM' => $request->input('alt_msl'),
                'AltAglM' => $request->input('alt_agl'),
            ]);
        } catch (\Exception $e) {
            if ($e->getCode() == 400) {
                return redirect()->back()->withErrors(['name' => 'Name must be unique'])->withError(['Invalid Name', 'This name already exists'])->withInput();
            } else {
                return redirect()->back()->withError(['Error '.$e->getCode(), 'Server response: '.$e->getMessage()])->withInput();
            }
        }

        $transceiver = json_decode($response);

        return redirect()->route('transceivers.show', ['id' => $transceiver->transceiverID])->withSuccess(['Transceiver created', null]);
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
            $response = AfvApiController::doGET("stations/transceivers/$searchFor");
        } catch (\Exception $e) {
            if ($e->getCode() == 404) {
                abort(404);
            } else {
                return redirect()->back()->withError([$e->getCode(), 'Server response: '.$e->getMessage()]);
            }
        }

        $transceiver = json_decode($response);

        return view('sections.transceivers.show', compact('transceiver'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $searchFor = rawurlencode($id);
            $response = AfvApiController::doGET("stations/transceivers/$searchFor");
        } catch (\Exception $e) {
            if ($e->getCode() == 404) {
                abort(404);
            } else {
                return redirect()->back()->withError([$e->getCode(), 'Server response: '.$e->getMessage()]);
            }
        }

        $transceiver = json_decode($response);

        return view('sections.transceivers.edit')->withTransceiver($transceiver);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'lat' => 'required|numeric|max:90|min:-90',
            'lon' => 'required|numeric|max:180|min:-180',
            'name' => 'required|string|regex:/^[a-zA-Z0-9_]+$/',
            'alt_msl' => 'required|integer|min:0',
            'alt_agl' => 'required|integer|min:0',
        ]);

        try {
            $response = AfvApiController::doPUT('stations/transceivers', [
                'TransceiverID' => $id,
                'Name' => strtoupper($request->input('name')),
                'LatDeg' => $request->input('lat'),
                'LonDeg' => $request->input('lon'),
                'AltMslM' => $request->input('alt_msl'),
                'AltAglM' => $request->input('alt_agl'),
            ]);
        } catch (\Exception $e) {
            if ($e->getCode() == 400) {
                return redirect()->back()->withErrors(['name' => 'Name must be unique'])->withError(['Invalid Name', 'This name already exists'])->withInput();
            } else {
                return redirect()->back()->withError(['Error '.$e->getCode(), 'Server response: '.$e->getMessage()])->withInput();
            }
        }

        $transceiver = json_decode($response);

        return redirect()->route('transceivers.show', ['id' => $transceiver->transceiverID])->withSuccess(['Transceiver updated', null]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $id = rawurlencode($id);
            $response = AfvApiController::doDELETE("stations/transceivers/$id");

            return redirect()->route('transceivers.index')->withSuccess(['Transceiver Deleted', null]);
        } catch (\Exception $e) {
            if ($e->getCode() == 404) {
                abort(404);
            } else {
                return redirect()->back()->withError([$e->getCode(), 'Server response: '.$e->getMessage()]);
            }
        }
    }
}
