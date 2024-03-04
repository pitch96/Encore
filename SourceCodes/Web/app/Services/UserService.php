<?php

namespace App\Services;

use App\Models\User;
use App\Models\Admin\Event;
use App\Models\Admin\Ticket;
use App\Models\TicketOrder;
use App\Models\Admin\Order;
use App\Models\Admin\ReferralEvent;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin\BillingAddress;
use Illuminate\Support\Facades\Crypt;

class UserService
{
    /**
     * User profile function service
     */
    public function getMyAccountData()
    {
        $user = Auth::user();
        $user->user_image = $user->user_profile ? asset('/user-images/'.$user->user_profile) : asset('no-image.png');
        $order_data = Order::select('id', 'order_details', 'order_placed_date', 'total_quantity', 'total_price', 'isCancelled')
                ->where('user_id', Auth::user()->id)
                ->orderBy('id', 'DESC')
                ->get();
        return [
            'user'          => $user,
            'order_data'    => $order_data
        ];
    }

    /**
     * Update user details by id service
     * @param [string] first_name
     * @param [string] last_name
     * @param [string] email
     */
    public function updateUserDetails($request, $id)
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
        $user->user_image = asset('/user-images/'.$user->user_profile);
        return $user;
    }

    /**
     * My Order Details service
     */
    public function getMyOrderData()
    {
        $order_data = Order::select('id', 'order_details', 'order_placed_date', 'total_quantity', 'total_price')
                ->where('user_id', Auth::user()->id)->get();
        return $order_data;
    }

    /**
     * My Billing address service
     */
    public function getBillingAddress()
    {
        $billingAddress = BillingAddress::where('user_id', Auth::user()->id)->get();
        return  $billingAddress;
    }

    /**
     * referred Event By Promoter service
     * @param['event_id'] INT
     * @param['user_id'] INT
     */
    public function referredEventByPromoter($event_id, $user_id)
    {
        $user = User::findOrFail(Crypt::decrypt($user_id));
        if ($user->user_type != config('constants.USER_TYPE')) {
            if (Crypt::decrypt($user_id) != Auth::user()->id) {
                $tickets = Ticket::where('event_id', $event_id)->activeTicket()->get();
                $event = Event::findOrFail($event_id);
                $event->image = asset('/event-images/'.$event->image);
                $referral_event = ReferralEvent::where(['event_id' => $event_id, 'receiver_id' => Auth::user()->id, 'status' => 0])->first();
                if (!isset($referral_event)) {
                    ReferralEvent::create([
                        'event_id'      => $event_id,
                        'sender_id'     => Crypt::decrypt($user_id),
                        'receiver_id'   => Auth::user()->id,
                        'status'        => 0
                    ]);
                    return [
                        'status'    => 'success',
                        'message'   => trans('messages.referred_event.able_to_use'),
                        'tickets'   => $tickets,
                        'event'     => $event
                    ];
                } elseif (isset($referral_event) && $referral_event->status === 0) {
                    return [
                        'status'    => 'error',
                        'message'   => trans('messages.referred_event.already_able_to_use')
                    ];
                } elseif (isset($referral_event) && $referral_event->status === 1) {
                    return [
                        'status'    => 'error',
                        'message'   => trans('messages.referred_event.already_ussed')
                    ];
                }
            } else {
                return [
                    'status'    => 'error',
                    'message'   => trans('messages.referred_event.same_user_error')
                ];
            }
        } else {
            return [
                'status'    => 'error',
                'message'   => trans('messages.referred_event.invalid_referral_link')
            ];
        }
    }

    /**
     * Return the ticket_number to generate the QR codes for API
     */
    public function QrCodes($id)
    {
        $qr = TicketOrder::where('order_id', $id)->with('orderData')->get();
        return $qr;
    }

    /**
     * Return the ticket_number to generate the QR codes for WEB
     */
    public function QrCodesWeb($request, $id)
    {
        $limit = 5;
        $page_no = $request->pageNum;
        $totalCount = TicketOrder::where('order_id', $id)
                        ->count();
        $qr = TicketOrder::where('order_id', $id)
                        ->with('orderData')
                        ->skip(($page_no-1)*$limit)
                        ->take($limit)
                        ->get();
        $record_returned = count($qr)*$page_no;
        if($totalCount === $record_returned) {
            $last_page = true;
        } else {
            $last_page = false;
        }
        return [
            'qr'    => $qr,
            'page_number' => $page_no,
            'last_page' => $last_page
        ];
    }

    /**
     * return function to check if the order price has been refunded or not.
     * 
     * @param [$id] int
     */
    public function findOrderDetails($id)
    {
        $order_details = Order::find($id);
        if($order_details->total_price > 0) {
            $charge = json_decode($order_details->payment_response)->id;
            $stripe = new \Stripe\StripeClient(
                config('constants.STRIPE_SECRET')
            );
            $refund_status = $stripe->charges->retrieve(
                $charge,
                []
            )->amount_refunded;
            if($refund_status > 0) {
                $msg = 'Amount refunded already!';
            } else {
                $msg ='Your refund amount is in-progress!';
            }
        } else {
            $msg = 'No amount was refundable because this was a free ticket order.';
        }
        return [
            'status' => true,
            'message' => $msg,
        ];
    }
}
