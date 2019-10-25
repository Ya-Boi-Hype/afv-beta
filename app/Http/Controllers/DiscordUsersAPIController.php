<?php

namespace App\Http\Controllers;

use App\Models\Discord_Account;

class DiscordUsersAPIController extends Controller
{
    public function __invoke()
    {
        $accounts = Discord_Account::all();
        $output = [];

        foreach ($accounts as $discord) {
            $rating = $discord->user->rating_atc;
            $sup = ($rating == 'SUP' || $rating == 'ADM');
            $output[$discord->id] = ['display_name' => $discord->name, 'sup' => $sup];
        }

        return response($output)->header('Content-Type', 'application/json');
    }
}
