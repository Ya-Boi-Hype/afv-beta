<?php

namespace App\Http\Controllers\Auth;

use Carbon\Carbon;
use App\Models\User;
use Vatsim\OAuth\SSO;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\AfvApiController;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

/**
 * This controller handles authenticating users for the application and
 * redirecting them to your home screen. The controller uses a trait
 * to conveniently provide its functionality to your applications.
 */
class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $sso;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('guest')->except('logout');

        $this->sso = new SSO(
            config('vatsim-sso.base'),
            config('vatsim-sso.key'),
            config('vatsim-sso.secret'),
            config('vatsim-sso.method'),
            config('vatsim-sso.cert')
        );
    }

    public function login(Request $request)
    {
        return $this->sso->login(route('auth.login.verify'), function ($key, $secret, $url) use ($request) {
            $request->session()->put('vatsimauth', compact('key', 'secret'));

            return redirect($url);
        }, function ($error) {
            Log::error('SSO Login Error - '.$error->getMessage());

            return redirect()->route('home')->withError(['Login failed', $error->getMessage()]);
        });
    }

    public function verifyLogin(Request $request)
    {
        $session = $request->session()->get('vatsimauth');
        $main = route('home');

        return $this->sso->validate(
            $session['key'],
            $session['secret'],
            Input::get('oauth_verifier'),
            function ($user) use ($request, $main) {
                $request->session()->forget('vatsimauth');

                try {
                    $permissions = Cache::rememberForever('permissions'.$user->id, function () use ($user) {
                        return array_diff(
                            AfvApiController::getPermissions($user->id), ['User Permission Read']
                        );
                    });
                } catch (\Exception $e) {
                    Log::warn('AFV Permissions Request failed');

                    return redirect()->route('home')->withError(['Uh, oh...', 'Something went wrong']);
                }
                if (! count($permissions)) {
                    Cache::forget('permissions'.$user->id);

                    return redirect()->route('home')->withError(['Nope!', 'You are not allowed to enter this site']);
                }

                $this->completeLogin($user);

                return redirect()->intended($main);
            },
            function ($error) use ($request) {
                Log::error('SSO Validation Error - '.$error->getMessage());

                return redirect()->route('home')->withError(['Login failed', $error->getMessage()]);
            }
        );
    }

    public function completeLogin($user)
    {
        $account = User::firstOrNew(['id' => $user->id]);

        $account->name_first = utf8_decode($user->name_first);
        $account->name_last = utf8_decode($user->name_last);
        $account->rating_atc = $user->rating->short;
        $account->joined_at = $user->reg_date;
        $account->last_login = Carbon::now();
        $account->save();

        return auth()->login($account, true);
    }

    public function logout()
    {
        Cache::forget('permissions'.auth()->user()->id);
        auth()->logout();

        return redirect(route('home'))->withSuccess(['Logout', 'You have been successfully logged out']);
    }
}
