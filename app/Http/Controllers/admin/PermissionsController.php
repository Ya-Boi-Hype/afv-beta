<?php

namespace App\Http\Controllers\Admin;

use App\Events\PermissionsUpdated;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\AfvApiController;

class PermissionsController extends Controller
{

    protected $availablePermissions = [
        "Facility Engineer",
        "User Enable Write",
        "User Permission Read",
        "User Permission Write"
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('id')){
            $request->validate(['id' => 'integer|min:800000|max:1500000']);
            $cid = $request->input('id');
            return redirect()->route('permissions.edit', ['id' => $cid]);
        } else {
            return view('sections.permissions.index');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if ($id == auth()->user()->id ){
            return redirect()->back()->withError(['Nice try', 'You can\'t edit your own permissions']);
        }
        try{
            $response = AfvApiController::doGET("users/$id/permissions");
            $hasPermissions = json_decode($response);
        } catch (\Exception $e) {
            if ($e->getCode() == 404) {
                abort(404);
            } elseif ($e->getCode() == 500) {
                return redirect()->back()->withError(500, 'AFV API Error');
            } else {
                return redirect()->back()->withError($e->getCode(), $e->getMessage());
            }
        }

        $allPermissions = $this->availablePermissions;
        
        return view('sections.permissions.edit', compact('id', 'hasPermissions', 'allPermissions'));
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
        if ($id == auth()->user()->id ){
            return redirect()->back()->withError(['Nice try', 'You can\'t edit your own permissions']);
        }

        $requestPermissions = [];

        foreach($this->availablePermissions as $permission) {
            $searchFor = str_replace(' ', '_', $permission);
            if ($request->input($searchFor, 'off') === 'on'){
                $requestPermissions[] = $permission;
            }
        }

        try{
            AfvApiController::doPUT("users/$id/permissions", $requestPermissions);
        } catch (\Exception $e) {
            return redirect()->back()->withError($e->getCode(), $e->getMessage());
        }

        Cache::forget("permissions$id");

        event(new PermissionsUpdated($id, $requestPermissions));

        return redirect()->route('permissions.edit', ['id' => $id])->withSuccess(['Done!', 'User Permissions Updated']);
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
