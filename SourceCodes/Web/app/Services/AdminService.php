<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Admin\Event;
use App\Models\Admin\Order;
use App\Models\Subscription;
use Illuminate\Support\Facades\DB;
use App\Models\Admin\StripeAccount;
use App\Models\Admin\ReferralEvent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;

class AdminService
{
    /**
     * View Admin profile page
     * Get the loggedIn user data service
     */
    public function profileDetail($request)
    {
        $user = Auth::user();
        if (isset($request->stripe_id)) {
            $account =  new StripeAccount();
            $account->email =  $user->email;
            $account->stripe_accountid = $request->stripe_id;
            $account->save();
        }
        $collection = Event::with('category')->where('user_id', Auth::user()->id)->orderBy('id', 'desc')->get();
        $events = $collection->map(function ($event, $key) {
            $current_timestamp = strtotime(Carbon::now()->format('Y-m-d H:i'));
            $start_timestamp = strtotime($event->start_date . ' ' . date("H:i", strtotime($event->start_time)));
            $end_timestamp = strtotime($event->end_date . ' ' . date("H:i", strtotime($event->end_time)));
            $status = '';
            $event->image = asset('/event-images/'.$event->image);
            if ($start_timestamp <= $current_timestamp && $end_timestamp >= $current_timestamp) {
                $status = 'Running';
            } elseif ($start_timestamp > $current_timestamp) {
                $status = 'Upcoming';
            } elseif ($end_timestamp < $current_timestamp) {
                $status = 'Expired';
            }
            $event['event_status'] = $status;
            return $event;
        });

        $total_booked_events = Order::select('event_id', DB::raw('count(*) as total'))
                ->where('sender_id', Auth::user()->id)->groupBy('event_id')->get();
        $referral_counts = ReferralEvent::select('event_id', DB::raw('count(*) as total'))
                ->where('sender_id', Auth::user()->id)->groupBy('event_id')->get();
        $total_refferal_amounts = Order::select('event_id', DB::raw('SUM(total_price) as total_price'))
                ->where('sender_id', Auth::user()->id)->groupBy('event_id')->get();
        $promoter_total_payout = Order::select(DB::raw('SUM(total_price) as total_payout'))
                ->where('sender_id', Auth::user()->id)->first()->toArray();
        
        if(Auth::user()->user_type === config('constants.ADMIN_TYPE')){
            $order_data = Order::orderBy('id', 'desc')->get();
        } else {
            $order_data = Order::where('sender_id', Auth::user()->id)->orderBy('id', 'desc')->get();        
        }

        $stripe_account = StripeAccount::where('email', $user->email)->first();

        return [
            'user'                      => $user,
            'events'                    => $events,
            'total_booked_events'       => $total_booked_events,
            'referral_counts'           => $referral_counts,
            'total_refferal_amounts'    => $total_refferal_amounts,
            'promoter_total_payout'     => $promoter_total_payout,
            'order_data'                => $order_data,
            'stripe_account'            => $stripe_account
        ];
    }

    public function totalPayout()
    {
        $promoter_total_payout = Order::select(DB::raw('SUM(total_price) as total_payout'))
                ->where('sender_id', Auth::user()->id)
                ->first()
                ->toArray();
        return $promoter_total_payout;
    }

    /*
    *Ruturn the purchase history for Admin/Promoters
    */
    public function myPurchase(){
        $order_data = Order::select('id', 'order_details', 'order_placed_date', 'total_quantity', 'total_price')
        ->where('user_id', Auth::user()->id)->get();
        return [
            'order_data'    => $order_data
        ];
    }

    /**
     * View Manage user page service
     * Get all users from users table
     */
    public function getAllActiveUser()
    {
        $users = User::getAllActiveUser()
            ->orderBy('id', 'desc')
            ->get();
        return $users;
    }

    /**
     * View Manage Promoter page service
     * Get all promoters from users table
     */
    public function getAllActivePromoter()
    {
        $promoters = User::getAllActivePromoter()
            ->orderBy('id', 'desc')
            ->get();
        return $promoters;
    }

    /**
     * Change the Verification status of the promoters
     */
    public function changeVerificationStatus($userID, $status)
    {
        User::findOrFail($userID)->update(['isVerified' => $status]);
            return [
                'status' => 'success',
                'message' => "Promoter's verification status changed."
            ];
    }

    /**
     * Edit User Details service by Id
     * @param [int] id
     */
    public function getUserOrPromoterById($id)
    {
        $user = User::findOrFail(Crypt::decrypt($id));
        return $user;
    }

    /**
     * Update user details service by id
     * @param [string] first_name
     * @param [string] last_name
     * @param [string] user_type
     * @param [string] email
     */
    public function updateUserPromoter($request, $id)
    {
        $user = User::findOrFail(Crypt::decrypt($id));
        if ($request->hasFile('user_profile')) {
            $file = $request->file('user_profile');
            $user_profile = time() . '_' . $file->getClientOriginalName();
            $request->user_profile->move(public_path('user-images'), $user_profile);
        } else {
            $user_profile = $user->user_profile;
        }
        $user->update([
            'first_name'    => $request->first_name,
            'last_name'     => $request->last_name,
            'phone_no'      => $request->phone_no,
            'company_name'  => $request->company_name,
            'user_profile'  => $user_profile,
        ]);
        return $user;
    }

    /**
     * change user password service
     * @param [string] old_password
     * @param [string] new_password
     * @param [string] confirm_password
     */
    public function changePassword($request)
    {
        $user = User::findOrFail(Auth::user()->id);
        if (!(Hash::check($request->get('old_password'), $user->password))) {
            // The passwords matches
            return [
                'status'    => "error",
                'message'   => trans('messages.change_password.error.password_not_match'),
            ];
        }
        if (strcmp($request->get('old_password'), $request->get('password')) === 0) {
            // Current password and new password same
            return [
                'status'    => "error",
                'message'   => trans('messages.change_password.error.same_password'),
            ];
        }
        $user->update([
            'password' => Hash::make($request->password),
        ]);
        return [
            'status'    => "success",
            'message'   => trans('messages.change_password.success.change'),
        ];
    }

    /**
     * Get all subscribed user list page service
     */
    public function subscribedUsers()
    {
        $subscribe_users = Subscription::where('status', 1)->get();
        return $subscribe_users;
    }

    /**
     *Delete subscribed user list according to ID
     */
    public function deleteSubscribedUsers($id)
    {
        $sub_id = Crypt::decrypt($id);
        $subscribe_user = Subscription::findorfail($sub_id);
        $subscribe_user->delete();
    }

    /**
     * Connect promoter to stripe service
     */
    public function connectPromoterWithStripe()
    {
        ini_set('session.referer_check', 'TRUE');
        $email =  Auth::user()->email;
        $stripe_result =  StripeAccount::Where('email', $email)->get();
        if (!count($stripe_result) > 0) {
            $accounts = Config::get('constants.STRIPE_ACCOUNT_API');
            $accountdata = [
                'type'      => 'express',
                'country'   => 'US',
                'email'     =>  $email,
                'capabilities' => [
                    'card_payments' => ['requested' => 'true'],
                    'transfers'     => ['requested' => 'true'],
                ]
            ];
            $accountd = $this->curlCall(config('constants.STRIPE_SECRET'), $accounts, 'POST', $accountdata);
            $links = Config::get('constants.STRIPE_ACCOUNT_LINKS_API');
            $refresh_url = url('admin/profile?stripe_id='.$accountd->id);
            $onbord_d = [
                'account'       => $accountd->id,
                'refresh_url'   => $refresh_url,
                'return_url'    => $refresh_url,
                'type'          => 'account_onboarding'
            ];
            $onbord_link = $this->curlCall(config('constants.STRIPE_SECRET'), $links, 'POST', $onbord_d);
            if (isset($onbord_link->url)) {
                return [
                    'status'    => 'success',
                    'url'       => $onbord_link->url
                ];
            } else {
                return [
                    'status' => 'error'
                ];
            }
        }
    }

    /**
     * Callback function
     */
    public function curlCall($stripe_key, $url, $request, $post)
    {
        try {
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    "Content-Type: application/x-www-form-urlencoded",
                        "Authorization: Bearer ".$stripe_key,
                    ));
            if ($request === 'POST') {
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
            }
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $request);
            // execute!
            $response = curl_exec($ch);
            $account_data = json_decode($response);
            if ($request === 'GET') {
                return $account_data;
                if (isset($account_data->id)) {
                    return $account_data;
                } else {
                    return trans('messages.stripe_error');
                }
            } elseif ($request === 'POST') {
                return json_decode($response);
            }
            //close the connection, release resources used
            curl_close($ch);
        } catch (\Exception $exception) {
            return Redirect::to('admin/profile')->with('error', $exception->getMessage());
        }
    }

    /*
    *Get Order details for Promoters
    */
    public function orderForMyEvents()
    {
        $order_datas = Order::where('sender_id', Auth::user()->id)
            ->orderBy('id', 'desc')
            ->get();
        $order_data = $order_datas->map(function($order, $key){
            $order->order_details = json_decode($order->order_details);
            $order->order_details->event_image = asset('/event-images/'.$order->order_details->event_image);
            $order->user = $order->user;
            return $order;
        });
        return $order_data;
    }
}
