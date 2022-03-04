<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\LineUser;
use Illuminate\Support\Facades\Http;
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
    public function redirectToProvider()
    {
        // $clientId = config('services.line.client_id');
        // $clientSecret = config('services.line.client_secret');
        // $redirectUrl = config('services.line.redirect');
        // $additionalProviderConfig = ['bot_prompt' => 'aggresive'];
        // $config = new \SocialiteProviders\Manager\Config($clientId, $clientSecret, $redirectUrl, $additionalProviderConfig);
        // return Socialite::driver($provider)->setConfig($config)->redirect();

        return Socialite::driver('line')->redirect();
    }

    /**
     * Obtain the user information from the provider.
     *
     * @param string $provider
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback()
    {

        $providedUser = Socialite::driver('line')->user();

        $user = LineUser::find($providedUser->id);

        if (!$user) {
            $user = LineUser::create([
                'id' => $providedUser->id,
                'name' => $providedUser->name ?? 'ノーネーム',
                'avatar' => $providedUser->avatar ?? asset('img/q.svg'),
            ]);
            $res = Http::withHeaders(['Authorization' => 'Bearer ' . config('services.line.messaging_api.access_token')])
                ->post("https://api.line.me/v2/bot/user/U359c48cffd2121dcb99513ee5fdf43f8/linkToken");
            $linkToken = $res->object()->linkToken;
            $nonce = \Str::random(24);
            return redirect("https://access.line.me/dialog/bot/accountLink?linkToken={$linkToken}&nonce={$nonce}");
        }
        Auth::login($user);

        return redirect()->route('home')->with('status', 'ログインに成功しました');
    }

    /**
     * Log the user out of the application.
     *
     * @return \Illuminate\Http\Response
     */
    public function logout()
    {
        Auth::logout();

        return redirect()->route('welcome')->with('status', 'ログアウトしました');
    }
}
