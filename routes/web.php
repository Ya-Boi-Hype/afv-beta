<?php

// Landing/Main Page
Route::get('/', 'PageController@home')->name('home');

//--------------------------------------------------------------------------
// Guest Endpoint
//--------------------------------------------------------------------------
Route::middleware('guest')->group(function () {
    Route::get('login', 'Auth\LoginController@login')->name('auth.login');
    Route::get('verify-login', 'Auth\LoginController@verifyLogin')->name('auth.login.verify');
});

//--------------------------------------------------------------------------
// Authenticated Endpoint
//--------------------------------------------------------------------------
Route::middleware('auth')->group(function () {
    Route::get('logout', 'Auth\LoginController@logout')->name('auth.logout');

    //--------------------------------------------------------------------------
    // User has no request to join
    //--------------------------------------------------------------------------
    Route::middleware('hasNoRequest')->group(function () {
        Route::get('request', 'UserRequestController@store')->name('request');
    });

    //--------------------------------------------------------------------------
    // User can express availability
    //--------------------------------------------------------------------------
    /*Route::middleware('expressAvailability')->group(function () {
        Route::put('request', 'UserRequestController@setAsAvailable')->name('request.available');
    });*/

    //--------------------------------------------------------------------------
    // Approved Users Endpoint
    //--------------------------------------------------------------------------
    Route::middleware('approved')->group(function () {
        Route::get('knowledge-base', 'PageController@knowledgeBase')->name('knowledge_base');
        Route::get('clients/pilots/vpilot', 'PageController@vPilot')->name('pilots.vpilot');
        Route::get('clients/pilots/xpilot', 'PageController@xPilot')->name('pilots.xpilot');
        Route::get('clients/pilots/swift', 'PageController@swift')->name('pilots.swift');
        Route::get('clients/pilots/xsb', 'PageController@xsb')->name('pilots.xsb');
        Route::get('clients/atc/euroscope-client', 'PageController@euroscope')->name('atc.euroscope');
        Route::get('clients/atc/vrc-vstars-veram', 'PageController@vrc_vstars_veram')->name('atc.vrc_vstars_veram');
        Route::get('clients/atis/euroscope', 'PageController@euroscopeAtis')->name('atis.euroscope');
        Route::get('clients/atis/vatis', 'PageController@vatis')->name('atis.vatis');
        Route::get('issues', 'PageController@issues')->name('issues');

        Route::get('prefile', 'FPLPrefileController@get')->name('prefile');
        Route::post('prefile', 'FPLPrefileController@post')->name('prefile.submit');

        Route::get('discord/login', 'DiscordOAuth2Controller@login')->name('discord.login');
        Route::get('discord/validate', 'DiscordOAuth2Controller@validateLogin');

        /*Route::get('discord', function(){
            return view('sections.discord.index')->withDiscord(auth()->user()->discord);
        });*/

        Route::get('client-download', function () {
            return response()->download(storage_path('app/Audio For VATSIM.msi'));
        })->name('client.download');
    });

    //--------------------------------------------------------------------------
    // Permission Management Endpoint
    //--------------------------------------------------------------------------
    Route::middleware('managePermissions')->group(function () {
        Route::resource('permissions', 'Admin\PermissionsController')->only(['index', 'edit', 'update']);
    });

    //--------------------------------------------------------------------------
    // Approval Management Endpoint
    //--------------------------------------------------------------------------
    Route::middleware('manageApprovals')->group(function () {
        Route::get('approvals/available', 'Admin\ApprovalController@availabilities')->name('approvals.availabilities');
        Route::put('approvals/available', 'Admin\ApprovalController@approveAvailable')->name('approvals.availabilities.approve');
        Route::delete('approvals/available', 'Admin\ApprovalController@resetAvailable')->name('approvals.availabilities.reset');
        Route::resource('approvals', 'Admin\ApprovalController')->only(['index', 'edit', 'update']);
        Route::get('approvals/random', 'Admin\ApprovalController@random');
    });

    //--------------------------------------------------------------------------
    // Facility Engineering Endpoint
    //--------------------------------------------------------------------------
    Route::middleware('facilityEngineer')->group(function () {
        //
    });

    //--------------------------------------------------------------------------
    // Facility Engineering ADMIN Endpoint
    //--------------------------------------------------------------------------
    Route::middleware('admin')->group(function () {
        //
    });
});

//--------------------------------------------------------------------------
// Discord Accounts
//--------------------------------------------------------------------------
Route::get('discord/accounts', 'DiscordUsersAPIController');

//--------------------------------------------------------------------------
// Dataserver-NG
//--------------------------------------------------------------------------
Route::get('vatsim-data', function () {
    return response(Storage::get('vatsim-data.json'))->header('Content-Type', 'application/json');
});
