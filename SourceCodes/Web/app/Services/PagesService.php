<?php

namespace App\Services;

use App\Jobs\MailJob;
use App\Models\ContactUs;
use App\Models\Subscription;
use App\Models\StaticContent;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;

class PagesService
{
    /**
     * Save contact Us data in contactus table service
     * @param['string']name
     * @param['string']email
     * @param['string']phone_no
     * @param['string']queries
     */
    public function storeContectUs($request)
    {
        $data = [
            'name'      => $request->name,
            'email'     => $request->email,
            'phone_no'  => $request->phone_no,
            'queries'   => $request->queries,
        ];
        $save = ContactUs::create($data);
        
        if(request()->ip() != '127.0.0.1'){
            //  Send mail to admin
            $template   = 'email.contactMail';
            $bodyData   = $data;
            $emailTo    = Config::get('constants.ADMIN_EMAIL3');
            $emailFrom  = $request->email;
            $subject    = 'User Queries';
            $mailType   = 'Contact Us';
        
            Mail::send($template, $bodyData, function ($message) use ($emailTo, $emailFrom, $subject, $mailType) {
                $message->from($emailFrom, $mailType);
                $message->to($emailTo);
                $message->subject($subject);
            });
        }
        return $save;
    }

    /**
     * Save subscription data in subscriptions table service
     * @param['string']email
     */
    public function subscribeEvent($request)
    {
        $data = [
            'email'     => $request->email,
            'status'    => 1,
        ];
        Subscription::create($data);
        //  Send mail to admin
        $template   = 'email.subscriptionMail';
        $bodyData   = $data;
        $emailTo    = $request->email;
        $emailFrom  = Config::get('constants.ADMIN_EMAIL5');
        $subject    = 'Subscribe';
        $mailType   = 'Subscribe';
        Mail::send($template, $bodyData, function ($message) use ($emailTo, $emailFrom, $subject, $mailType) {
            $message->from($emailFrom, $mailType);
            $message->to($emailTo);
            $message->subject($subject);
        });
        return true;
    }

    /**
     * Unsubscription data in subscriptions table service
     * @param['string']email
     */
    public function unSubscribeEvent($email)
    {
        $data = Subscription::where('email', $email)->first();
        if ($data) {
            $data->delete();
            return [
                'status'    => 'success',
                'message'   => trans('messages.unsubscribe')
            ];
        } else {
            return [
                'status'    => 'error',
                'message'   => trans('messages.emailId_error')
            ];
        }
    }

    /**
     * Unsubscription data in subscriptions table service
     * @param['string']email
     */
    public function staticContentData($page_id)
    {
        $data = StaticContent::where('page_id', $page_id)->first();
        if ($data) {
            return [
                'status'    => 'success',
                'message'   => trans('messages.record_found'),
                'data'      => trim(strip_tags(preg_replace("/\r|\n|\t/", "", $data->content)))
            ];
        } else {
            return [
                'status'    => 'error',
                'message'   => trans('messages.record_not_found')
            ];
        }
    }
}
