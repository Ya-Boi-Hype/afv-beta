<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Discord_Account;
use App\Http\Controllers\Controller;

class DiscordAccountController extends Controller
{
    public function update($cid, Request $request)
    {
        $id = $request->input('id', '');
        if (strlen($id) == 0) {
            Discord_Account::where('user_id', $cid)->delete();
        } else {
            Discord_Account::updateOrCreate(
                ['user_id' => $cid],
                [
                    'id' => $id,
                ]
            );
        }

        return redirect()->back()->withSuccess('Discord ID successfully updated');
    }
}
