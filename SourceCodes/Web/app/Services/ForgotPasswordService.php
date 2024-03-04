<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\User;
use App\Jobs\MailJob;
use Illuminate\Support\Str;
use App\Models\UsersVerify;
use App\Models\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;

class ForgotPasswordService
{
    /**
     * service
     * Forgot password function for change the password if user forgot her/his password.
     * @param['email'] string
     */
    public function forgotPassword($request)
    {
        $token = Str::random(64);
        PasswordReset::where(['email'=> $request->email])->delete();
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
        $mailType   = 'Reset Password Link';
        Mail::send($template, $bodyData, function ($message) use ($emailTo, $emailFrom, $subject, $mailType) {
            $message->from($emailFrom, $mailType);
            $message->to($emailTo);
            $message->subject($subject);
        });
        return true;
    }

    /**
     * Reset password function for reset the password service
     * @param['token'] string
     * @param['email'] string
     * @param['password'] string
     * @param['password_confirmation'] string
     */
    public function resetPassword($request)
    {
        $updatePassword = PasswordReset::where([
            'email' => $request->email,
            'token' => $request->token
        ])
        ->first();
        if (!$updatePassword) {
            return [
                'status'    => 'error',
                'message'   => trans('messages.wrong_token')
            ];
        }
        User::where('email', $request->email)
        ->update(['password' => Hash::make($request->password)]);
        PasswordReset::where(['email'=> $request->email])->delete();
        return [
            'status'    => 'success',
            'message'   => trans('messages.forgot_message.change_success')
        ];
    }

    /**
     * service
     * Forgot password function for change the password if user forgot her/his password.
     * @param['email'] string
     */
    public function forgotPasswordOtp($request)
    {
        $otp = random_int(100000, 999999);
        PasswordReset::where(['email'=> $request->email])->delete();
        PasswordReset::insert([
            'email'       => $request->email,
            'token'       => $otp,
            'created_at'  => Carbon::now()
        ]);
        $template   = 'email.forgetPasswordOtp';
        $bodyData   = ['otp' => $otp];
        $emailTo    = $request->email;
        $emailFrom  = Config::get('constants.ADMIN_EMAIL2');
        $subject    = 'Reset Password';
        $mailType   = 'Reset Password Link';
        Mail::send($template, $bodyData, function ($message) use ($emailTo, $emailFrom, $subject, $mailType) {
            $message->from($emailFrom, $mailType);
            $message->to($emailTo);
            $message->subject($subject);
        });
        return true;
    }

    /**
     * Reset password function for reset the password service
     * @param['otp'] string
     * @param['email'] string
     * @param['password'] string
     * @param['password_confirmation'] string
     */
    public function resetPasswordOtp($request)
    {
        $updatePassword = PasswordReset::where([
            'email' => $request->email,
            'token' => $request->otp
        ])
        ->first();
        if (!$updatePassword) {
            return [
                'status'    => 'error',
                'message'   => trans('messages.wrong_otp')
            ];
        }
        User::where('email', $request->email)
        ->update(['password' => Hash::make($request->password)]);
        PasswordReset::where(['email'=> $request->email])->delete();
        return [
            'status'    => 'success',
            'message'   => trans('messages.reset_password')
        ];
    }

    /**
     * Verify user Mail function service
     * @param['token'] string
     */
    public function verifyMail($token)
    {
        $verifyUser = UsersVerify::where('token', $token)->first();
        $message = trans('messages.email_cannot_identified');
        if (!is_null($verifyUser)) {
            $user = $verifyUser->user;
            if (!$user->is_email_verified) {
                $verifyUser->user->is_email_verified = 1;
                $verifyUser->user->email_verified_at = Carbon::now()->format('Y-m-d H:i:s');
                $verifyUser->user->save();

                $template   = 'email.welcomeMail';
                $bodyData   = ['first_name' => $user->first_name];
                $emailTo    = $user->email;
                $emailFrom  = Config::get('constants.ADMIN_EMAIL2');
                $subject    = 'Welcome to EncoreEvents';
                $mailType   = 'Registration Mail';
                Mail::send($template, $bodyData, function ($message) use ($emailTo, $emailFrom, $subject, $mailType) {
                    $message->from($emailFrom, $mailType);
                    $message->to($emailTo);
                    $message->subject($subject);
                });
                $message = trans('messages.email_verified');
            } else {
                $message = trans('messages.email_already_verified');
            }
            return [
                'status'        => 'success',
                'message'       => $message
            ];
        } else {
            return [
                'status'        => 'error',
                'message'       => $message
            ];
        }
    }
}
