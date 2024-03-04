<?php

namespace App\Services;

use App\Models\User;
use App\Jobs\MailJob;
use Illuminate\Support\Str;
use App\Models\UsersVerify;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;

class AuthService
{
    /**
     * Register function for create new user service
     * @param['first_name'] string
     * @param['last_name'] string
     * @param['phone_no'] string
     * @param['email'] string
     * @param['company_name'] string
     * @param['password'] string
     * @param['password_confirmation'] string
     */
    public function register($request)
    {
        $user = User::create([
            'user_type'     => $request->user_type,
            'first_name'    => $request->first_name,
            'last_name'     => $request->last_name,
            'email'         => $request->email,
            'phone_no'      => $request->phone_no,
            'company_name'  => $request->company_name,
            'password'      => Hash::make($request->password)
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
            $subject    = 'Email Verification';
            $mailType   = 'Email Verification';
            Mail::send($template, $bodyData, function ($message) use ($emailTo, $emailFrom, $subject, $mailType) {
                $message->from($emailFrom, $mailType);
                $message->to($emailTo);
                $message->subject($subject);
            });
        }
        return $user;
    }
}
