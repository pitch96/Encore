<?php

namespace App\Http\Controllers\Auth;

use Carbon\Carbon;
use App\Models\User;
use App\Jobs\MailJob;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\PasswordReset;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;

class ForgotPasswordController extends Controller
{
    /**
     * Show forgot password form
     *
     */
    public function showForgetPasswordForm()
    {
        return view('auth.forgetPassword');
    }

    /**
     * Forgot password function for change the password if user forgot her/his password.\
     * @param['email'] string
     */
    public function submitForgetPasswordForm(Request $request)
    {
        $request->validate([
              'email' => 'required|email|exists:users',
          ]);

        try {
            $token = Str::random(64);

            PasswordReset::insert([
                'email'       => $request->email,
                'token'       => $token,
                'created_at'  => Carbon::now()
            ]);

            $template   = 'email.forgetPassword';
            $bodyData   = ['token' => $token];
            $emailTo    = $request->email;
            $emailFrom  = Config::get('constants.ADMIN_EMAIL2');
            $subject    = 'Reset Password';
            $mailType   = 'Reset Password link';
            // dispatch(new MailJob($template, $bodyData, $emailTo, $emailFrom, $subject, $mailType));
            Mail::send($template, $bodyData, function ($message) use ($emailTo, $emailFrom, $subject, $mailType) {
                $message->from($emailFrom, $mailType);
                $message->to($emailTo);
                $message->subject($subject);
            });
            return Redirect::to('/login')->withSuccess(trans('messages.forgot_message.reset_link'));
        } catch (\Exception $exception) {
            return Redirect::back()->withErrors($exception->getMessage());
        }
    }

    /**
     * Show reset password form
     *
     */
    public function showResetPasswordForm($token)
    {
        return view('auth.forgetPasswordLink', ['token' => $token]);
    }

    /**
     * Reset password function for reset the password
     * @param['token'] string
     * @param['email'] string
     * @param['password'] string
     * @param['password_confirmation'] string
     */
    public function submitResetPasswordForm(Request $request)
    {
        $request->validate([
            'email'                 => 'required|email|exists:users',
            'password'              => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required'
        ]);
        try {
            $updatePassword = PasswordReset::where([
            'email'     => $request->email,
            'token'     => $request->token
            ])
            ->first();
            if (!$updatePassword) {
                return back()->withInput()->with('error', trans('messages.wrong_token'));
            }
            $user = User::where('email', $request->email)
            ->update(['password' => Hash::make($request->password)]);
            PasswordReset::where(['email'=> $request->email])->delete();
            return Redirect::to('/login')->withSuccess(trans('messages.forgot_message.change_success'));
        } catch (\Exception $exception) {
            return Redirect::back()->withErrors($exception->getMessage());
        }
    }
}
