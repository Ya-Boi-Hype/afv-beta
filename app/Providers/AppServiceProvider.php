<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::if('approved', function () {
            return auth()->user()->approved || auth()->user()->admin;
        });

        Blade::if('pending', function () {
            return auth()->user()->pending && ! auth()->user()->admin;
        });

        Blade::if('canexpressavailability', function () {
            return auth()->user()->has_request && ! auth()->user()->approval->available;
        });
        
        Blade::if('canJoinDiscord', function () {
            return (bool) (auth()->user()->rating_atc == 'SUP' || auth()->user()->rating_atc == 'ADM' || in_array('Facility Engineer', auth()->user()->permissions));
        });

        Blade::if('hasnorequest', function () {
            return ! auth()->user()->has_request && ! auth()->user()->admin;
        });

        Blade::if('admin', function () {
            return auth()->user()->admin;
        });

        Blade::if('facilityEngineer', function () {
            return (bool) in_array('Facility Engineer', auth()->user()->permissions);
        });

        Blade::if('managesApprovals', function () {
            return (bool) in_array('User Enable Write', auth()->user()->permissions);
        });

        Blade::if('managesPermissions', function () {
            return (bool) in_array('User Permission Write', auth()->user()->permissions);
        });

        Blade::if('hasSomePermission', function () {
            return (bool) count(auth()->user()->permissions);
        });

        Blade::if('hasDiscord', function () {
            return (bool) auth()->user()->discord;
        });
    }
}
