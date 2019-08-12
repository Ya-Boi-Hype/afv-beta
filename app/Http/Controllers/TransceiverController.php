<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Webpatser\Uuid\Uuid;

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
            'search' => 'required|string',
        ]);
        $data = ['searchText' => $request->input('search')];

        try {
            $searchResults = AfvApiController::doPOST('api/v1/stations/transceivers/search', $data);
        } catch (Exception $e) {
            return redirect()->back()->withError(['AFV Server Error', 'Server replied with '.$e->getMessage()]);
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
            'alt_msl' => 'required|integer',
            'alt_agl' => 'required|integer',
        ]);

        $transceiverID = (string) Uuid::generate();
        try{
            $response = AfvApiController::doPUT('api/v1/stations/transceivers', [
                'TransceiverID' => $transceiverID,
                'Name' => $request->input('name'),
                'LatDeg' => $request->input('lat'),
                'LonDeg' => $request->input('lon'),
                'AltMslM' => $request->input('alt_msl'),
                'AltAglM' => $request->input('alt_agl'),
            ]);
            return redirect()->page('transceivers.show', ['id' => $transceiverID])->withSuccess(['Transceiver created', $response]);
        } catch (\Exception $e) {
            return redirect()->back()->withError(['AFV Server Error', "Server replied with ".$e->getMessage()])->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $name
     * @return \Illuminate\Http\Response
     */
    public function show($name)
    {
        try {
            $response = AfvApiController::doGET("api/v1/stations/transceivers/$name");
            $transceiver = json_decode($response);
        } catch (\Exception $e) {
            return redirect()->route('transceivers.index')->withError(['AFV Server Error', "Server replied with ".$e->getMessage()])->withInput();
        }
        
        echo "<pre>";
        print_r($transceiver);
        echo "</pre>";
        die();
        $transceiver = [
            'name' => 'Test',
            'lat' => 0.0,
            'lng' => 0.0,
            'alt_msl' => 0.0,
            'alt_agl' => 21,
        ];

        return view('sections.transceivers.show')->withTransceiver($transceiver);
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
