<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Discord_Account;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Wohali\OAuth2\Client\Provider\Discord;
use Wohali\OAuth2\Client\Provider\Exception\DiscordIdentityProviderException;

class DiscordController extends Controller
{
    /**
     * @var Discord
     */
    private $provider;

    /**
     * @var array
     */
    private $scopes = ['identify'];

    /**
     * Initializes the provider variable.
     */
    protected function initProvider()
    {
        $this->provider = new Discord([
            'clientId' => config('discord.clientId'),
            'clientSecret' => config('discord.clientSecret'),
            'redirectUri' => config('discord.redirectUri'),
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hasAccount = auth()->user()->discord()->exists();

        return view('sections.discord.index', compact('hasAccount'));
    }

    /**
     * Link a new account (redirects to Discord login).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if (! empty($request->input('code'))) {
            return $this->store($request);
        }

        $this->initProvider();

        $options = [
            'scope' => $this->scopes,
        ];
        $authUrl = $this->provider->getAuthorizationUrl($options);
        //$authUrl = $this->provider->getAuthorizationUrl();

        Log::info('DiscordOAuth2Controller - Redirecting user to login');
        session()->put('oauth2state', $this->provider->getState());
        session()->save();
        header('Location: '.$authUrl);
        die();
    }

    /**
     * Link a new account (handles callback from Discord login).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->initProvider();
        $cid = auth()->user()->id;

        if (empty($request->input('code'))) {
            return redirect()->route('discord.login');
        }

        if (empty($request->input('state')) || ($request->input('state') !== session('oauth2state'))) {
            $expects = session('oauth2state');
            $receives = $request->input('state', 'None');
            Log::error("State mismatch ($cid): Expected $expects - Received $receives");
            session()->forget('oauth2state');

            return redirect()->route('discord.index')->withError(['State Mismatch', 'Please try again. It it still fails, let us know.']);
        }

        try {
            $token = $this->provider->getAccessToken('authorization_code', ['code' => $request->input('code')]);
        } catch (DiscordIdentityProviderException $e) {
            return redirect()->route('discord.login');
        }

        try {
            $user = $this->provider->getResourceOwner($token);
        } catch (Exception $e) {
            return redirect()->route('discord.index')->withError(['Hmmmm...', 'Uh, oh... we\'re having trouble finding your Discord Account']);
        }

        if ( // If the user hasn't granted us the permissions we need, we ignore the token and return an error.
            ! strstr($token->getValues()['scope'], 'identify')
        ) {
            return redirect()->route('discord.index')->withError(['Oops...', 'Something went wrong. Please try again']);
        }

        Log::info("$cid linked Discord Account");
        Discord_Account::where('id', $user->getId())->delete(); //Delete any other records using the same Discord_ID (one CID == one Discord_ID)

        Discord_Account::updateOrCreate([
            'user_id' => $cid,
        ], [
            'id' => $user->getId(),
        ]);

        return redirect()->route('discord.index')->withSuccess(['Aye!', 'Discord account successfully linked!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Discord_Account  $discord
     * @return \Illuminate\Http\Response
     */
    public function show(Discord_Account $discord)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Discord_Account  $discord
     * @return \Illuminate\Http\Response
     */
    public function edit(Discord_Account $discord)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Discord_Account  $discord
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Discord_Account $discord)
    {
        $request->validate([
            'account_mode' => 'required|integer|in:0,1,2',
        ]);

        $discord->mode = $request->input('account_mode');
        $discord->save();

        return redirect()->route('discord.index')->withSuccess(['No problem!', 'Allow some time for the bot to update your name on Discord']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Discord_Account  $discord_Account
     * @return \Illuminate\Http\Response
     */
    public function destroy(Discord_Account $discord_Account)
    {
        //
    }
}
