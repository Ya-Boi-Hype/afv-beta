<?php

Route::get('/', function() {
    return view('home');
})->name('home');

//--------------------------------------------------------------------------
// Guest Endpoint
//--------------------------------------------------------------------------
Route::middleware('guest')->group(function () {
    Route::get('login', 'Auth\LoginController@login')->name('auth.login');
    Route::get('login/verify', 'Auth\LoginController@verifyLogin')->name('auth.login.verify');
});

//--------------------------------------------------------------------------
// Authenticated Endpoint
//--------------------------------------------------------------------------
Route::middleware('auth')->group(function () {
    Route::get('logout', 'Auth\LoginController@logout')->name('auth.logout');
    
    Route::middleware('facilityEngineer')->group(function () {
        Route::resource('discord', 'DiscordController')->only(['index', 'create']);
    });

    //--------------------------------------------------------------------------
    // Permission Management Endpoint
    //--------------------------------------------------------------------------
    Route::middleware('managePermissions')->group(function () {
        Route::resource('permissions', 'Admin\PermissionsController')->only(['index', 'edit', 'update']);
    });
});

//--------------------------------------------------------------------------
// Discord Accounts
//--------------------------------------------------------------------------
Route::get('discord/accounts', 'DiscordUsersAPIController');
