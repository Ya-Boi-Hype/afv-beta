<?php

return [

    /*
    |--------------------------------------------------------------------------
    | API
    |--------------------------------------------------------------------------
    |
    | This value is the AFV API base URL
    |
    */

    'api' => env('AFV_API', ''),

    /*
    |--------------------------------------------------------------------------
    | Network Version
    |--------------------------------------------------------------------------
    |
    | This value is Network Version (else we get client not compatible)
    |
    */

    'networkVersion' => env('AFV_NET_VER', ''),

    /*
    |--------------------------------------------------------------------------
    | Username
    |--------------------------------------------------------------------------
    |
    | This value is the AFV API username
    |
    */

    'user' => env('AFV_USERNAME', ''),

    /*
    |--------------------------------------------------------------------------
    | Password
    |--------------------------------------------------------------------------
    |
    | This value is the AFV API password
    |
    */

    'pass' => env('AFV_PASSWORD', ''),
];
