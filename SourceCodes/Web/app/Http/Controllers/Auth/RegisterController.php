<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Jobs\MailJob;
use App\Models\UsersVerify;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name'    => ['required', 'string', 'max:50'],
            'last_name'     => ['required', 'string', 'max:50'],
            'user_type'     => ['required'],
            'phone_no'      => 'required|max:14|min:14|regex:/^([0-9\s\-\+\(\)]*)$/',
            'email'         => 'required|string|email|unique:users|regex:/(.+)@(.+)\.(.+)/i',
            'password'      => ['required', 'string', 'min:6', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'user_type'     => $data['user_type'],
            'first_name'    => $data['first_name'],
            'last_name'     => $data['last_name'],
            'email'         => $data['email'],
            'phone_no'      => $data['phone_no'],
            'company_name'  => $data['company_name'],
            'password'      => Hash::make($data['password']),
        ]);
        if (isset($user)) {
            $token = Str::random(64);

            UsersVerify::create([
                'user_id'   => $user->id,
                'token'     => $token
            ]);
            $template   = 'email.emailVerificationEmail';
            $bodyData   = ['token' => $token];
            $emailTo    = $user->email;
            $emailFrom  = Config::get('constants.ADMIN_EMAIL2');
            $subject    = 'Email Verification Mail';
            $mailType   = 'Email Verification';
            if(request()->ip() != '127.0.0.1') {
                Mail::send($template, $bodyData, function ($message) use ($emailTo, $emailFrom, $subject, $mailType) {
                    $message->from($emailFrom, $mailType);
                    $message->to($emailTo);
                    $message->subject($subject);
                });
            }
            return $user;
        }
    }

    protected function registered($user)
    {
        if ($user->user_type == config('constants.PROMOTER_TYPE')) {
            $message = trans('messages.promoter_user.success.promoter_registered');
        } else {
            $message = trans('messages.admin_user.success.user_registered');
        }
        Session::flush();
        Auth::logout();
        return Redirect::to('/login')->with('success', $message);
    }
}
