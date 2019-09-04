<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Discord_Account;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Wohali\OAuth2\Client\Provider\Discord;
use Wohali\OAuth2\Client\Provider\Exception\DiscordIdentityProviderException;

/**
 * Class DiscordOAuth2Controller.
 */
class DiscordOAuth2Controller extends Controller
{
    /**
     * @var Discord
     */
    private $provider;

    private $scopes = ['identify'];

    /**
     * DiscordOAuth2Controller constructor.
     */
    public function __construct()
    {
        $this->provider = new Discord([
            'clientId' => config('discord.clientId'),
            'clientSecret' => config('discord.clientSecret'),
            'redirectUri' => config('discord.redirectUri'),
        ]);
    }

    /**
     * Redirect user to Discord Authentication for login.
     */
    public function login()
    {
        $options = [
            'scope' => $this->scopes,
        ];
        $authUrl = $this->provider->getAuthorizationUrl($options);
        //$authUrl = $this->provider->getAuthorizationUrl();
        Log::info("DiscordOAuth2Controller - Saving state to redirect user to login with Discord");
        session()->put('oauth2state', $this->provider->getState());
        session()->save();
        header('Location: '.$authUrl);
        die();
    }

    /**
     * Validate the login.
     *
     * @param Request $get
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function validateLogin(Request $get)
    {
        $cid = auth()->user()->id;

        if (empty($get->input('code'))) {
            return redirect()->route('discord.login');
        }

        if (empty($get->input('state')) || ($get->input('state') !== session('oauth2state'))) {
            $expects = session('oauth2state');
            $receives = $get->input('state', 'None');
            Log::error("State mismatch ($cid): Expected $expects - Received $receives");
            session()->forget('oauth2state');

            return redirect()->route('home')->withError(['State Mismatch', 'Please try again. It it still fails, let us know.']);
        }

        try {
            $token = $this->provider->getAccessToken('authorization_code', ['code' => $get->input('code')]);
        } catch (DiscordIdentityProviderException $e) {
            return redirect()->route('discord.login');
        }

        try {
            $user = $this->provider->getResourceOwner($token);
        } catch (Exception $e) {
            return redirect()->route('home')->withError(['Hmmmm...', 'Uh, oh... we\'re having trouble finding your Discord Account']);
        }

        if ( // If the user hasn't granted us the permissions we need, we ignore the token and return an error.
            ! strstr($token->getValues()['scope'], 'identify')
        ) {
            return redirect()->route('home')->withError(['Oops...', 'Something went wrong. Please try again']);
        }

        Log::info("$cid linked Discord Account");
        Discord_Account::where('id', $user->getId())->delete(); //Delete any other records using the same Discord_ID (one CID == one Discord_ID)
        Discord_Account::updateOrCreate(
            ['user_id' => $cid],
            [
                'id' => $user->getId(),
            ]
        );

        return redirect()->route('home')->withSuccess(['Aye!', 'Discord account successfully linked!']);
    }
}
