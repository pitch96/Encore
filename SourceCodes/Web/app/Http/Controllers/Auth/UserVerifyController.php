<?php

namespace App\Http\Controllers\Auth;

use Carbon\Carbon;
use App\Jobs\MailJob;
use App\Models\UsersVerify;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;

class UserVerifyController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function verifyAccount($token)
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
                $mailType   = 'Welcome Mail';
                Mail::send($template, $bodyData, function ($message) use ($emailTo, $emailFrom, $subject, $mailType) {
                    $message->from($emailFrom, $mailType);
                    $message->to($emailTo);
                    $message->subject($subject);
                });
                $message = trans('messages.email_verified');
            } else {
                $message = trans('messages.email_already_verified');
            }
        }

        return Redirect::to('/login')->withSuccess($message);
    }
}
