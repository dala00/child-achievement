<?php

namespace App\Http\Controllers\Auth;

use App\Auth\Google;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

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
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        $data = [
            'googleLoginUrl' => Google::getLoginUrl(),
        ];
        return view('auth.login', $data);
    }

    public function callback(Request $request)
    {
        $client = Google::createClient();
        $token = $client->authenticate($request->input('code'));

        try {
            $profile = Google::getProfile($client, $token);
        } catch (Exception $e) {
            exit('Something went wrong: ' . $e->getMessage());
        }

        $user = User::where('google_auth', $profile->id)->first();
        if (!$user) {
            $user = new User;
            $user->google_auth = $profile->id;
            $user->save();
        }
        Auth::login($user, true);

        return redirect('home');
    }
}
