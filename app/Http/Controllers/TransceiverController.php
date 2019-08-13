<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull;

class TransceiverController extends Controller
{
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
        ]);
        $search = ($request->input('search')) ?? ''; // Because 'convertEmptyStringstoNull' middleware made API return 500
        $data = ['searchText' => $search];

        try {
            $searchResults = AfvApiController::doPOST('api/v1/stations/transceivers/search', $data);
        } catch (\Exception $e) {
            return redirect()->back()->withError(['Poopsie - '.$e->getCode(), 'Server response: '.$e->getMessage()])->withInput();
        }

        return view('sections.transceivers.search_results')->withSearchResults(json_decode($searchResults));
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
        return view('sections.transceivers.create');
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
            'name' => 'required|string',
            'alt_msl' => 'required|integer|min:0',
            'alt_agl' => 'required|integer|min:0',
        ]);

        try {
            $response = AfvApiController::doPOST('api/v1/stations/transceivers', [
                'Name' => $request->input('name'),
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
            $response = AfvApiController::doGET("api/v1/stations/transceivers/$searchFor");
        } catch (\Exception $e) {
            if ($e->getCode() == 404) {
                abort(404);
            } else {
                return redirect()->back()->withError([$e->getCode(), 'Server response: '.$e->getMessage()]);
            }
        }

        $transceiver = json_decode($response);

        return view('sections.transceivers.show')->withTransceiver($transceiver);
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
            $response = AfvApiController::doGET("api/v1/stations/transceivers/$searchFor");
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
            'name' => 'required|string',
            'alt_msl' => 'required|integer|min:0',
            'alt_agl' => 'required|integer|min:0',
        ]);

        try {
            $response = AfvApiController::doPUT('api/v1/stations/transceivers', [
                'TransceiverID' => $id,
                'Name' => $request->input('name'),
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
            $response = AfvApiController::doDELETE("api/v1/stations/transceivers/$id");

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
