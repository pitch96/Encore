<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->redirectTo = url()->previous();
    }

    /**
     * Write Your Code..
     *
     * @return string
    */
    public function showLoginForm(Request $request)
    {
        // if (!($request->session()->has('intendedUrl')) && str_replace(url('/'), '', url()->previous()) !== '/admin/dashboard') {
        //     $request->session()->put('intendedUrl', str_replace(url('/'), '', url()->previous()));
        // }
        return view('auth.login');
    }

    protected function authenticated(Request $request, $user)
    {
        if ($request->rememberme === null) {
            setcookie('login_email', $request->email, 100);
            setcookie('login_pass', $request->password, 100);
        } else {
            setcookie('login_email', $request->email, time()+60*60*24*100);
            setcookie('login_pass', $request->password, time()+60*60*24*100);
        }
        if ($user->status === 0) {
            $message = trans('messages.admin_user.error.not_active');
            // Log the user out.
            $this->logout($request);
            // Return them to the log in form.
            return Redirect::back()
                ->withInput($request->only($this->username(), 'remember'))
                ->withErrors([
                    // This is where we are providing the error messages.
                    $this->username() => $message,
                ]);
        }
        if (!Auth::user()->is_email_verified) {
            auth()->logout();
            $this->logout($request);
            return Redirect::to('/login')->withError(trans('messages.email_not_varify_error'));
        }
        if ($user->user_type === config('constants.ADMIN_TYPE') || $user->user_type === config('constants.PROMOTER_TYPE')) {
            return Redirect::to('/admin/dashboard')->with('success', trans('messages.admin_user.success.admin_loggedIn'));
        } else {
            return Redirect::to('/')->with('success', trans('messages.admin_user.success.user_loggedIn'));
        }
    }
}
