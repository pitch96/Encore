<?php

namespace App\Services;

use Stripe;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Models\Admin\Order;
use App\Models\TicketOrder;
use App\Models\Admin\Event;
use App\Models\Admin\AddToCart;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Admin\ReferralEvent;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin\BillingAddress;
use Illuminate\Support\Facades\Config;
use App\Http\Traits\StripePaymentTrait;

class OrderService
{
    use StripePaymentTrait;

    /**
     * Placed cart items service
     * Save data in orders
     * Save billing address data in billing_address table
     * Update tickets table
     * Update add_to_carts table
     * @param['int'] user_id
     * @param['string'] cart_id
     * @param['string'] billing_address
     */
    public function orderTickets($request)
    {
        $cartDatas = AddToCart::where(['user_id' => Auth::user()->id])->with(['ticket'])->get();
        $totalPrice = 0;
        if (count($cartDatas) > 0) {
            foreach ($cartDatas as $item) {
                $totalPrice += $item->quantity * $item->ticket->price;
            }
        }
        $cart_items = $request->cart_items;
        $user_id = $request->user_id;
        $billing_address = $request->billing_address;
        $total_price = (float)$request->total_price;
        if ($totalPrice > $total_price) {
            return [
                'status'    => 'error',
                'message'   => trans('messages.insufficient_amount').$totalPrice,
            ];
        }
        if ($totalPrice < $total_price) {
            return [
                'status'    => 'error',
                'message'   => trans('messages.extra_amount').$totalPrice,
            ];
        }
        if ($totalPrice === 0.0) {
            $latestOrder = Order::orderBy('created_at', 'DESC')->first();
            if (isset($latestOrder)) {
                $order_no = '#'.str_pad($latestOrder->id + 1, 8, "0", STR_PAD_LEFT);
            } else {
                $order_no = '#'.str_pad(1, 8, "0", STR_PAD_LEFT);
            }
            $payment_response = ["message" => trans('messages.payment_success')];
            $charge_status = (object)[
                "id"        => $order_no,
                "status"    => "succeeded"
            ];
            Log::channel('stripepaymentlogforbuyer')->info($payment_response);
            $this->paymentSuccessOrFailed($cart_items, $user_id, $billing_address, $total_price, $payment_response, $charge_status);
            DB::commit();
            return [
                'status'    => 'success',
                'message'   => trans('messages.order_success'),
            ];
        }

        Stripe\Stripe::setApiKey(config('constants.STRIPE_SECRET'));
        $customer = Stripe\Customer::create(array(
            "address" => [
                "line1"         => $billing_address['address'],
                "postal_code"   => $billing_address['zipcode'],
                "state"         =>  $billing_address['state'],
            ],
            "email"     =>  $billing_address['email'],
            "name"      => $billing_address['full_name'],
            "source"    => $request->stripeToken
        ));

        $charge =  Stripe\Charge::create([
            "amount"        => $total_price *100,
            "currency"      => "usd",
            "customer"      =>  $customer->id ,
            "description"   => "Test payment from EncoreEvents"
        ]);

        if (!empty($charge)) {
            $payment_response = $this->successPaymentResponse($charge);
            Log::channel('stripepaymentlogforbuyer')->info($payment_response);
            $this->paymentSuccessOrFailed($cart_items, $user_id, $billing_address, $total_price, $payment_response, $charge);
            DB::commit();
            return [
                'status'    => 'success',
                'message'   => trans('messages.order_success'),
            ];
        } else {
            return [
                'status'    => 'error',
                'message'   => 'Payment Error!',
            ];
        }
    }

    public function paymentSuccessOrFailed($cart_items, $user_id, $billing_address, $total_price, $payment_response, $charge)
    {
        $cart_data = AddToCart::where('id', $cart_items)->with(['ticket.event','ticket.event.category'])->first();
        $order_details = [
            'event_id'              => $cart_data->ticket->event->id,
            'event_title'           => $cart_data->ticket->event->event_title,
            'category_name'         => $cart_data->ticket->event->category->name,
            'event_organizer'       => $cart_data->ticket->event->organizer,
            'event_venue'           => $cart_data->ticket->event->venue,
            'event_address'         => $cart_data->ticket->event->address,
            'event_city'            => $cart_data->ticket->event->city,
            'event_zipcode'         => $cart_data->ticket->event->zipcode,
            'event_start_date'      => $cart_data->ticket->event->start_date,
            'event_end_date'        => $cart_data->ticket->event->end_date,
            'event_start_time'      => $cart_data->ticket->event->start_time,
            'event_end_time'        => $cart_data->ticket->event->end_time,
            'event_image'           => $cart_data->ticket->event->image,
            'event_description'     => $cart_data->ticket->event->description,
            'ticket_title'          => $cart_data->ticket->ticket_title,
            'ticket_type'           => $cart_data->ticket->ticket_type,
            'ticket_price'          => $cart_data->ticket->price,
            'ticket_purchase_qty'   => $cart_data->quantity,
            'total_price'           => $cart_data->ticket->price * $cart_data->quantity,
        ];
        $new_quantity = $cart_data->ticket->quantity - $cart_data->quantity;
        $sold_quantity = $cart_data->ticket->no_of_sold_tickets + $cart_data->quantity;
        $cart_data->ticket->update([
            'quantity'              => $new_quantity,
            'no_of_sold_tickets'    => $sold_quantity
        ]);
        $cart_data->delete();
        BillingAddress::where('user_id', $user_id)->update(['active' => 0]);
        $get_address = $billing_address['active_address_id'] != '' ? BillingAddress::findOrFail($billing_address['active_address_id']) : null;
        $data = [
            'user_id'       => $user_id,
            'full_name'     => $billing_address['full_name'],
            'phone_no'      => $billing_address['phone_no'],
            'email'         => $billing_address['email'],
            'zipcode'       => $billing_address['zipcode'],
            'state'         => $billing_address['state'],
            'city'          => $billing_address['city'],
            'address'       => $billing_address['address'],
            'active'        => 1
        ];
        if (isset($get_address)) {
            $get_address->update($data);
        } else {
            BillingAddress::create($data);
        }
        $referral_event = ReferralEvent::where(['receiver_id' => $user_id, 'event_id' => $cart_data->ticket->event->id, 'status' => 0])->first();
        if (isset($referral_event)) {
            $sender_id = $referral_event->sender_id;
            $referral_event->update(['status' => 1, 'no_of_bought_ticket' => $cart_data->quantity]);
        } else {
            $sender_id = Event::where('id', $cart_data->ticket->event->id)
                ->first()
                ->user_id;
        }
        $total_sold_ticket_count = Order::selectRaw('SUM(total_quantity) as total_sold_ticket')
                ->where('event_id', $cart_data->ticket->event->id)->first()->toArray();
        $order = Order::create([
            'user_id'           => $user_id,
            'sender_id'         => $sender_id,
            'event_id'          => $cart_data->ticket->event->id,
            'order_no'          => $charge->id,
            'billing_address'   => json_encode($billing_address),
            'order_details'     => json_encode($order_details),
            'total_quantity'    => $cart_data->quantity,
            'total_price'       => $total_price,
            'currency'          => $charge->currency ?? 'usd',
            'order_placed_date' => date('Y-m-d H:i:s'),
            'payment_status'    => $charge->status,
            "payment_response"  => json_encode($payment_response),
        ]);
        $order_id = $order->id;
        for ($i = 0; $i < $cart_data->quantity; $i++) {
            $ticket_no = Str::random(15);
            $order = TicketOrder::create([
                'order_id'           => $order_id,
                'ticket_no'          => strtoupper($ticket_no)
            ]);
        }
        $qr_number = TicketOrder::where('order_id', $order_id)->get();
        $mail_body_content = [
            'qr_numbers'                => $qr_number,
            'order_id'                  => $order_id,
            'order_no'                  => $charge->id,
            'order_details'             => json_encode($order_details),
            'billing_address'           => json_encode($billing_address),
            'full_name'                 => $billing_address['full_name'],
            'email'                     => $billing_address['email'],
            'total_sold_ticket_count'   => $total_sold_ticket_count['total_sold_ticket'] + 1,
            'order_placed_date'         => date('m/d/Y H:i:s'),
        ];
        $template   = 'email.purchased-mail';
        $bodyData   = $mail_body_content;
        $emailTo    = $mail_body_content['email'];
        $emailFrom  = Config::get('constants.ADMIN_EMAIL2');
        $subject    = 'New Order';
        $mailType   = 'New Order';
        Mail::send($template, $bodyData, function ($message) use ($emailTo, $emailFrom, $subject, $mailType) {
            $message->from($emailFrom, $mailType);
            $message->to($emailTo);
            $message->subject($subject);
        });
        return true;
    }

    public function qrDetails($order_id, $ticket_no)
    {
        $ticket_no = base64_decode($ticket_no);
        $order_detail = Order::select('order_details')->find(base64_decode($order_id));
        $order_details = json_decode($order_detail->order_details);
        return [
            'order_details' => $order_details,
            'ticket_no'     => $ticket_no
        ];
    }

    public function qrScanDetails($ticket_no)
    {
        $ticket_details = TicketOrder::where('ticket_no', $ticket_no)->with('orderData')->first();
        $order = Order::where(['id' => $ticket_details->order_id])->with(['event'])->first();
        $current_timestamp = strtotime(Carbon::now()->format('Y-m-d H:i'));
        $end_time = strtotime($order->event->end_date . ' ' . date("H:i", strtotime($order->event->end_time)));
        
        if($current_timestamp > $end_time){
            return [
                'status' => false,
                'message' => 'Event has expired',
                'data' => []
            ];
        }else if(Auth::user()->id != $order->sender_id){
            return [
                'status' => false,
                'message' => 'You are not allowed to perform this action. This ticket does not belong to your event.',
                'data' => []
            ];
        } else {
            if (isset($ticket_details)) {
                if ($ticket_details->is_checked === 1) {
                    return [
                        'status' => false,
                        'message' => trans('messages.already_checked'),
                        'data' => $ticket_details
                    ];
                } else {
                    $ticket_details->update(['is_checked' => 1]);
                    $ticket_details->orderData->order_details = json_decode($ticket_details->orderData->order_details);
                    return [
                        'status' => true,
                        'message' => trans('messages.record_found'),
                        'data' => $ticket_details
                    ];
                }
            } else {
                return [
                    'status' => false,
                    'message' => trans('messages.record_not_found'),
                    'data' => []
                ];
            }
        }        
    }
}
