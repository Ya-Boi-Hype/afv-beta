<?php

namespace App\Http\Controllers;

use App\Models\Discord_Account;

class DiscordUsersAPIController extends Controller
{
    public function __invoke()
    {
        $accounts = Discord_Account::all();
        $output = [];

        foreach ($accounts as $account) {
            $rating = $account->user->rating_atc;
            $sup = ($rating == 'SUP' || $rating == 'ADM');
            $name = mb_convert_case(mb_strtolower($account->user->full_name.' - '.$account->user->id), MB_CASE_TITLE, 'UTF-8');
            $output[$account->id] = ['display_name' => $name, 'approved' => $account->user->approved, 'sup' => $sup];
        }

        return response($output)->header('Content-Type', 'application/json');
    }
}
