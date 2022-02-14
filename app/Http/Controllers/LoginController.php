<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\LineUser;
use Jdenticon\Identicon;

class LoginController extends Controller
{
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Redirect the user to the provider authentication page.
     *
     * @param string $provider
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider($provider)
    {
        // $clientId = config('services.line.client_id');
        // $clientSecret = config('services.line.client_secret');
        // $redirectUrl = config('services.line.redirect');
        // $additionalProviderConfig = ['bot_prompt' => 'aggresive'];
        // $config = new \SocialiteProviders\Manager\Config($clientId, $clientSecret, $redirectUrl, $additionalProviderConfig);
        // return Socialite::driver($provider)->setConfig($config)->redirect();

        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from the provider.
     *
     * @param string $provider
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback($provider)
    {

        $providedUser = Socialite::driver($provider)->user();

        $user = LineUser::find($providedUser->id);

        if (!$user) {
        }

        $user = LineUser::firstOrCreate(
            [
                'id' => $providedUser->id,
            ],
            [
                'id' => $providedUser->id,
                'name' => $providedUser->name ?? 'ノーネーム',
                'avatar' => $providedUser->avatar ?? asset('img/q.svg'),
            ]
        );
        Auth::login($user);

        return redirect()->route('home');
    }

    /**
     * Log the user out of the application.
     *
     * @return \Illuminate\Http\Response
     */
    public function logout()
    {
        Auth::logout();

        return redirect()->route('home');
    }
}