<?php
/**
 * EventService File Doc Comment
 * PHP version 7
 *
 * @category Class
 * @package  Package
 * @author   Encore Events <info@encoreevents.live>
 * @license  URL General
 * @link     https://encoreevents.live/
 */

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Admin\PromoterAccess;
use App\Models\Admin\Event;
use App\Models\Admin\Order;
use App\Models\Admin\Ticket;
use App\Models\Admin\StripeAccount;
use Stripe;
use App\Jobs\MailJob;
use Illuminate\Support\Facades\Mail;
use App\Http\Traits\StripePaymentTrait;
use App\Models\TicketOrder; 
use App\Models\PromotionalEventCharge; 
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

/**
 * Verifies that control statements conform to their coding standards.
 *
 * @category PHP
 * @package  EventService
 * @author   Encore Events <info@encoreevents.live>
 * @license  URL General
 * @version  Release: @package_version@
 * @link     https://encoreevents.live/
 */
class EventService
{
    use StripePaymentTrait;

    /**
     * View Manage Event Page service
     *
     * Here we get all the events on the basis of loggedIn user from events table
     *
     * @param Request $request array
     *
     * @return event
     */
    public function allEvents($request)
    {
        if (isset($request->events) && $request->events === 'all_events') {
            $collection = Event::whereNotIn('user_id', [Auth::user()->id])
                            ->where('status', 1)
                            ->where('isCancelled', 0)
                            ->orderBy('id', 'desc')
                            ->with('promoterRequestResponse')
                            ->get();
        } else {
            $collection = Event::where('user_id', Auth::user()->id)
                            ->where('isCancelled', 0)
                            ->orderBy('id', 'desc')
                            ->with('promoterRequestResponse')
                            ->get();
        }
        $events = $collection->map(
            function ($event, $key) {
                $current_timestamp = strtotime(Carbon::now()->format('Y-m-d H:i'));
                $start_timestamp = strtotime(
                    $event->start_date . ' ' . date(
                        "H:i",
                        strtotime(
                            $event->start_time
                        )
                    )
                );
                $paybleAmount = PromotionalEventCharge::first()->charge;
                $end_timestamp = strtotime($event->end_date . ' ' . date("H:i", strtotime($event->end_time)));
                $status = '';
                if ($start_timestamp <= $current_timestamp && $end_timestamp >= $current_timestamp) {
                    $status = 'Running';
                } elseif ($start_timestamp > $current_timestamp) {
                    $status = 'Upcoming';
                } elseif ($end_timestamp < $current_timestamp) {
                    $status = 'Expired';
                    $event->status = 0;
                    $event->isPopular = 0;
                }
                $event['paybleAmount'] = $paybleAmount;
                $event['event_status'] = $status;
                return $event;
            }
        );
        return $events;
    }

    /**
     * Function to return the event and order details
     *
     * @param Request $request array
     *
     * @return response
     */
    public function eventOrderAndDetails($request)
    {
        $myAllEvents = Event::where('user_id', Auth::user()->id)
                ->where('isCancelled', 0)
                ->orderBy('id', 'desc')
                ->get();
        $events = $myAllEvents->map(
            function ($event, $request) {
                $event->start_date = strtotime($event->start_date . ' ' . date("H:i", strtotime($event->start_time)));
                $event->end_date = strtotime($event->end_date . ' ' . date("H:i", strtotime($event->end_time)));
                return $event;
            }
        );
        $current_timestamp = strtotime(Carbon::now()->format('Y-m-d H:i'));
        if (isset($request->events) && $request->events === 'expired_events') {
            $collection = $events->where('end_date', '<', $current_timestamp);
        } else {
            $collection = $events->where('end_date', '>', $current_timestamp);
        }
        if (count($collection) > 0) {
            foreach ($collection as $e) {
                $status = '';
                $totalTickets = Order::select(DB::raw('SUM(total_quantity) as tickets_sold'))->where('event_id', $e['id'])
                    ->first()
                    ->toArray();
                $e['tickets_sold'] = $totalTickets;
    
                $revenue = Order::select(DB::raw('SUM(total_price) as revenue_generated'))->where('event_id', $e['id'])
                    ->first()
                    ->toArray();
                $e['revenue'] = $revenue;
    
                $e['order'] = Order::join('tickets', 'tickets.event_id', '=', 'orders.event_id')
                    ->join('users', 'users.id', '=', 'orders.user_id')
                    ->select('orders.id', 'users.first_name', 'users.last_name', 'users.user_profile', 'orders.order_details', 'orders.order_placed_date')
                    ->where('orders.event_id', $e['id'])
                    ->distinct()
                    ->get()
                    ->toArray();
    
                $start_date_dummy = $e['start_date'];
                $end_date_dummy = $e['end_date'];
                if ($start_date_dummy <= $current_timestamp && $end_date_dummy >= $current_timestamp) {
                    $status = 'Running';
                } elseif ($end_date_dummy < $current_timestamp) {
                    $status = 'Expired';
                } elseif ($start_date_dummy > $current_timestamp) {
                    $status = 'Upcoming';
                }
                
                $e['start_date'] = date("m-d-Y", $e['start_date']);
                $e['end_date'] = date("m-d-Y", $e['end_date']);
                $e['event_status'] = $status;
                $event_details[] = $e;
            }
            foreach ($event_details as $r) {
                $totalGuest = 0;
                for ($i = 0; $i < count($r['order']); $i++) {
                    $totalGuest +=  TicketOrder::where('order_id', $r['order'][$i]['id'])
                        ->where('is_checked', 1)
                        ->count();
                    $r['guestCount'] = $totalGuest;
                }
                $response[] = $r;
            }
            return $response;
        }else {
            return null;
        }
    }

    /**
     * Store event in events Table service
     *
     * @param Request $request array
     *
     * @return event
     */
    public function storeEvent($request)
    {
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $image = time() . '_' . $file->getClientOriginalName();
            $request->image->move(public_path('event-images'), $image);
        } else {
            $image = null;
        }
        if ($request->hasFile('venue_image')) {
            $file = $request->file('venue_image');
            $venue_image = time() . '_' . $file->getClientOriginalName();
            $request->venue_image->move(public_path('event-images'), $venue_image);
        } else {
            $venue_image = null;
        }
        $event = Event::create(
            [
                'user_id'           => Auth::user()->id,
                'event_title'       => $request->event_title,
                'category_id'       => $request->category_id,
                'organizer'         => $request->organizer,
                'venue'             => $request->venue,
                'address'           => $request->address,
                'city'              => $request->city,
                'zipcode'           => $request->zipcode,
                'start_date'        => $request->start_date,
                'end_date'          => $request->end_date,
                'start_time'        => $request->start_time,
                'end_time'          => $request->end_time,
                'description'       => $request->description,
                'verifiedPromoterEvent' => Auth::user()->isVerified === 1 ? 1 : 0,
                'image'             => $image,
                'venue_image'             => $venue_image,
            ]
        );
        if(Auth::user()->user_type === config('constants.PROMOTER_TYPE') && Auth::user()->isVerified === 1) {
            $save = PromoterAccess::create(
                [
                    'order_no'              => 'NULL',
                    'admin_id'              => 1,
                    'event_id'              => $event->id,
                    'event_created_by'      => Auth::user()->id,
                    'promoter_id'           => Auth::user()->id,
                    'date'                  => date('Y-m-d H:i:s'),
                    'status'                => 0,
                    "amount"                => '0',
                    'currency'              => 'NULL',
                    'payment_status'        => 'Free',
                    "payment_response"      => 'NULL',
                    'verifiedPromoterEvent' => 1
                ]
            );
        } 
        return $event;
    }


    /**
     * Update event by event id service
     *
     * @param $id      int
     * @param Request $request array
     *
     * @return response
     */
    public function updateEvent($id, $request)
    {
        $event = Event::findOrFail(Crypt::decrypt($id));
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $image = time() . '_' . $file->getClientOriginalName();
            $request->image->move(public_path('event-images'), $image);
        } else {
            $image = $event->image;
        }
        if ($request->hasFile('venue_image')) {
            $file = $request->file('venue_image');
            $venue_image = time() . '_' . $file->getClientOriginalName();
            $request->venue_image->move(public_path('event-images'), $venue_image);
        } else {
            $venue_image = $event->venue_image;
        }
        $event->update(
            [
                'event_title'       => $request->event_title,
                'category_id'       => $request->category_id,
                'organizer'         => $request->organizer,
                'venue'             => $request->venue,
                'address'           => $request->address,
                'city'              => $request->city,
                'zipcode'           => $request->zipcode,
                'start_date'        => $request->start_date,
                'end_date'          => $request->end_date,
                'start_time'        => $request->start_time,
                'end_time'          => $request->end_time,
                'description'       => $request->description,
                'image'             => $image,
                'venue_image'             => $venue_image,
                'status'            => 0
            ]
        );
        return $event;
    }

    /**
     * Delete event Details service
     *
     * @param $id int
     *
     * @return true
     */
    public function deleteEvent($id)
    {
        $event = Event::findOrFail(Crypt::decrypt($id));
        Ticket::where('event_id', $event->id)->delete();
        PromoterAccess::where('event_id', $event->id)->delete();
        $event->delete();
    }

    /**
     * All cancelled event listings
     */
    public function allCancelledEvents($request)
    {
        if (isset($request->events) && $request->events === 'refund_history') {
            $collections = Event::where('isCancelled', 1)
                ->where('verifiedPromoterEvent', 0)
                ->where('refund_status', '!=', 0)
                ->with('promoterRequestResponse')
                ->orderBy('updated_at', 'desc')
                ->get();
            $collection = $collections->map(function ($event, $key) {
                $amount = $this->getStripeChargeAmount($event->id);
                $event['amount_refunded'] =  $amount;
                return $event;
            });
        } else {
            $collections = Event::where('isCancelled', 1)
                ->where('verifiedPromoterEvent', 0)
                ->where('refund_status', 0)
                ->with('promoterRequestResponse')
                ->orderBy('updated_at', 'desc')
                ->get();
            $collection = [];
            foreach($collections as $event) {
                if($event->promoterRequestResponse) {
                    $collection[] = $event;
                }
            }
        }
        return $collection;
    }

    /**
     * Stripe API to find the refunded amount for cancelled events
     */
    public function getStripeChargeAmount($id) 
    {
        $charge = PromoterAccess::where('event_id', $id)->first()->order_no;
        if($charge) {
            $stripe = new \Stripe\StripeClient(
                config('constants.STRIPE_SECRET')
            );
            $price = $stripe->charges->retrieve(
                $charge,
                []
                )->amount_refunded;
                return $price/100;
            } else {
                return 0;
            }
    }

    /**
     * All cancelled event list for promoters
     */
    public function myCancelledEventsList()
    {
        $collection = Event::where('user_id', Auth::user()->id)
                            ->where('isCancelled', 1)
                            ->orderBy('id', 'desc')
                            ->get();
        return $collection;
    }

    /**
     * Cancel event Functionality
     * 
     * @param $event_id int
     * 
     * @return response
     */
    public function cancelEvent($request, $event_id)
    {
        $event = Event::findOrFail($event_id);
        $event->update([
            'isCancelled' => 1,
            'cancellationReason' => $request->reason
        ]);
        $orders = Order::where('event_id', $event->id)
                ->where('payment_status', 'succeeded')
                ->where('isCancelled', 0)
                ->get();
        $this->cancelOrdersForCancelledEvents($orders);
        return [
            'status' => true,
            'message' => 'Event Cancelled Successfully!'
        ];
    }

    /**
     * Cancel the orders for the cancelled events
     * 
     * @param $orders array
     * 
     */
    public function cancelOrdersForCancelledEvents($orders)
    {
        $orders->map(function($order, $key) {
            $order->update(['isCancelled' => 1]);
            if ($order->total_price > 0){
                $pymt_response = (json_decode($order->payment_response));
                $pymt_charge = $pymt_response->id;
                $response = $this->initiateRefundAfterCancellingOrders($pymt_charge);
                if ($response['refund_response_status'] === 'succeeded') {
                    $order->update(['payment_status' => 'refunded']);
                    Log::channel('striperefundlogforusers')->info($response['refund_response']);
                }
            }
            $this->deleteTicketsForCancelledOrder($order->id);
            $event_details = json_decode($order->order_details);
            $user_details = json_decode($order->billing_address); 
            $this->sendEventCancellationNotificationMail($event_details, $user_details);
            return $order;
        });
    }

    /**
     * Initiate refund for all orders of respective event after cancelling specific event
     * 
     * @param $charge int
     */
    public function initiateRefundAfterCancellingOrders($charge)
    {
        $stripe = new \Stripe\StripeClient(
            config('constants.STRIPE_SECRET')
        );
        $refundable_amount = $stripe->charges->retrieve(
            $charge,
            []
          )->amount;

          $refund_response = $stripe->refunds->create([
            'charge' => $charge,
            'amount' => ($refundable_amount - (2.9/(100))*$refundable_amount)-30
        ]);
        return [
            'refund_response' => $refund_response,
            'refund_response_status' => $refund_response->status,
        ];

    }

    /**
     * Delete tickets for cancelled event's orders.
     * 
     * @param $id int
     */
    public function deleteTicketsForCancelledOrder($id)
    {
        $tickets = TicketOrder::where('order_id', $id)->delete();
    }

    /**
     * Send event cancellation notification mail to buyers
     * 
     * @param $event_details, $pymt_response array
     * 
     * @param $pymt_response array
     */
    public function sendEventCancellationNotificationMail($event_details, $user_details)
    {
        if ($event_details->ticket_price > 0) {
            $refund_data = true;
        } else {
            $refund_data = false;
        }
        $template = 'email.event-cancel-notification-mail';
        $mailData = [
            'email' => $user_details->email,
            'name'  => $user_details->full_name,
            'eventName' => $event_details->event_title,
            'startDate' => $event_details->event_start_date,
            'refund_data' => $refund_data
        ];
        $bodyData   = ['data' => $mailData];
        $emailTo    = $mailData['email'];
        $emailFrom  = Config::get('constants.ADMIN_EMAIL2');
        $subject    = 'Event Cancellation';
        $mailType   = 'Event Cancelled';
        Mail::send(
            $template,
            $bodyData,
            function ($message) use ($emailTo, $emailFrom, $subject, $mailType) {
                $message->from($emailFrom, $mailType);
                $message->to($emailTo);
                $message->subject($subject);
            }
        );
    }

    /**
     * Change event status service
     *
     * @param $id     int
     * @param $status int
     *
     * @return true
     */
    public function changeEventStatus($id, $status)
    {
        $event_id = Crypt::decrypt($id);
        $date = Carbon::parse(Carbon::now())->toDateString();
        $time = Carbon::parse(Carbon::now())->toTimeString();
        $ticket = Ticket::activeTicket()
                        ->where('event_id', $event_id)
                        ->first();
        if (empty($ticket) && $status == 1) {
            $events = Event::where('user_id', Auth::user()->id)
                ->allEvents()
                ->get();
            return [
                'status' => 'error',
                'events' => $events,
                'event_id' => $event_id
            ];
        } else {
            $event = Event::findOrFail($event_id);
            if ($status == 0) {
                $event->update(['status' => $status,
                                'isPopular' => 0
                            ]);
            } else {
                $event->update(['status' => $status
                            ]);
            }
            return [
                'status' => 'success'
            ];
        }
    }

    /**
     * Change the popularity status of the events
     *
     * @param $id int
     * @param $status int
     * 
     * @return true
     */
    public function changeEventPopularityStatus($id, $status)
    {
        Event::findOrFail($id)->update(['isPopular' => $status]);
        return [
            'status' => 'success'
        ];
    }

    /**
     * Get events by id service
     *
     * @param $id int
     *
     * @return true
     */
    public function getEventById($id)
    {
        $stripe_account =  StripeAccount::Where('email', Auth::user()->email)->first();
        $event = Event::with('category')->findOrFail(Crypt::decrypt($id));
        $event->image = asset('/event-images/' . $event->image);
        $payment_status = '';
        if ($event->verifiedPromoterEvent === 1) {
            $payment_status = 'Free';
        } else {
            $payment_status = 'succeeded';
        }
        $promotion_event = PromoterAccess::where(
            [
                'event_id' => Crypt::decrypt($id),
                'promoter_id' => Auth::user()->id,
                'payment_status' => $payment_status
            ]
        )->first();
        $url = url()->previous();
            if ($url == asset('admin/promotion/list')) {
                $url = asset('admin/promotion/list');
            } elseif ($url == asset('admin/promotion/list?events=free_events')) {
                $url = asset('admin/promotion/list?events=free_events');
            } else {
                $url = asset('admin/manage/events');
            }
        return [
            'stripe_account' => $stripe_account,
            'event' => $event,
            'promotion_event' => $promotion_event,
            'url' => $url
        ];
    }


    /**
     * Promoter requested to admin for an event service
     *
     * @param Request $request array
     *
     * @return true
     */
    public function accessRequestForEventByPromoter($request)
    {
        $admin_id = User::where('user_type', config('constants.ADMIN_TYPE'))->first()->id;
        $getData = PromoterAccess::where(
            [
                'event_id' => $request->event_id,
                'promoter_id' => Auth::user()->id
            ]
        )->first();
        if (!isset($getData)) {
            $save = PromoterAccess::create(
                [
                    'admin_id'          => $admin_id,
                    'event_id'          => $request->event_id,
                    'event_created_by'  => $request->event_created_by,
                    'promoter_id'       => Auth::user()->id,
                    'date'              => date('Y-m-d'),
                    'status'            => 0
                ]
            );
            return true;
        } else {
            return false;
        }
    }

    
    /**
     * Get all Promotion list data with event detail, category and promoter detail on admin service
     *
     * @return promotionEvents
     */
    public function promoterRequestToAdminForPromoteEvent($request)
    {
        if (Auth::user()->id === config('constants.ADMIN_TYPE')) {
            if(isset($request->events) && $request->events === 'free_events') {
                $collection = PromoterAccess::with(['events.category', 'promoter'])
                    ->where('verifiedPromoterEvent', 1)
                    ->orderBy('id', 'desc')
                    ->get();
            } else {
                $collection = PromoterAccess::with(['events.category', 'promoter'])
                ->where('payment_status', 'succeeded')
                ->orderBy('id', 'desc')
                ->get();
            }
            $promotionEvents = $collection->map(
                function ($promotionEvent, $key) {
                    $current_timestamp = strtotime(Carbon::now()->format('Y-m-d H:i'));
                    $start_timestamp = strtotime($promotionEvent->events->start_date . ' ' . date("H:i", strtotime($promotionEvent->events->start_time)));
                    $end_timestamp = strtotime($promotionEvent->events->end_date . ' ' . date("H:i", strtotime($promotionEvent->events->end_time)));
                    $status = '';
                    if ($start_timestamp <= $current_timestamp && $end_timestamp >= $current_timestamp) {
                        $status = 'Running';
                    } elseif ($start_timestamp > $current_timestamp) {
                        $status = 'Upcoming';
                    } elseif ($end_timestamp < $current_timestamp) {
                        $status = 'Expired';
                    }
                    $promotionEvent['event_status'] = $status;
                    return $promotionEvent;
                }
            );
            return $promotionEvents;
        } else {
            return null;
        }
    }

    /**
     * Admin manage the promoter access service
     *
     * @param $status             int 0 for Pending, 1 for Approved, 2 for Reject
     * @param $promotion_event_id int
     *
     * @return promotionEvents
     */
    public function adminActionOnPromoterEventRequest($status, $promotion_event_id)
    {
        $promotionEvent = PromoterAccess::find($promotion_event_id);
        $mailData = [
            'email' => $promotionEvent->promoter->email,
            'name'  => $promotionEvent->promoter->first_name . ' ' . $promotionEvent->promoter->last_name,
            'eventName' => $promotionEvent->events->event_title,
            'startDate' => $promotionEvent->events->start_date
        ];
        $bodyData   = ['data' => $mailData];
        $emailTo    = $mailData['email'];
        $emailFrom  = Config::get('constants.ADMIN_EMAIL2');
        $subject    = 'Request Status';
        $mailType   = 'Admin Response';
        if ($status === '0') {
            $promotionEvent->update(['status' => 0]);
            $message = trans('messages.promoter_access.request_pending');
        } elseif ($status === '1') {
            $template   = 'email.approvedMail';
            Mail::send(
                $template,
                $bodyData,
                function ($message) use ($emailTo, $emailFrom, $subject, $mailType) {
                    $message->from($emailFrom, $mailType);
                    $message->to($emailTo);
                    $message->subject($subject);
                }
            );
            $promotionEvent->update(['status' => 1]);
            $message = trans('messages.promoter_access.request_approved');
        } else {
            $template   = 'email.rejectedMail';
            Mail::send(
                $template,
                $bodyData,
                function ($message) use ($emailTo, $emailFrom, $subject, $mailType) {
                    $message->from($emailFrom, $mailType);
                    $message->to($emailTo);
                    $message->subject($subject);
                }
            );
            $promotionEvent->update(['status' => 2]);
            $message = trans('messages.promoter_access.request_rejected');
        }
        return $message;
    }

    /**
     * Handling payment with POST service
     *
     * @param Request $request array
     *
     * @return true
     */
    public function promoterPayForEventAccess($request)
    {
        $paybleAmount = PromotionalEventCharge::first()->charge;
        $promoter = Auth::user();
        Stripe\Stripe::setApiKey(config('constants.STRIPE_SECRET'));
        $customer = Stripe\Customer::create(
            array(
                "email"     => $promoter->email,
                "name"      => $promoter->first_name . ' ' . $promoter->last_name,
                "source"    => $request->stripeToken
            )
        );
        $charge = Stripe\Charge::create(
            [
                "amount"        => $paybleAmount * 100,
                "currency"      => "usd",
                "customer"      =>  $customer->id, 
                "description"   => "Test payment from EncoreEvents"
            ]
        );
        if (!empty($charge)) {
            $payment_response = $this->successPaymentResponse($charge);
            Log::channel('stripepaymentlogforpromoter')->info($payment_response);
            $response = $this->paymentSuccessOrFailed($request, $promoter, $payment_response, $charge);
            return $response;
        } else {
            return [
                'status'    => 'fail',
                'message'   => 'Payment Failed',
            ];
        }
    }

    /**
     * Handling payment with POST service
     *
     * @param Request $request          array
     * @param $promoter         string
     * @param $payment_response int
     * @param $charge           int
     *
     * @return true
     */
    public function paymentSuccessOrFailed($request, $promoter, $payment_response, $charge)
    {
        $admin_details = User::where('user_type', config('constants.ADMIN_TYPE'))->first();
        $event_details = Event::findOrFail($request->event_id);
        $getData = PromoterAccess::where(
            [
                'event_id' => $request->event_id,
                'promoter_id' => Auth::user()->id,
                'payment_status' => 'succeeded'
            ]
        )->first();
        $data = [
            //Promoter detail
            'name'              => $promoter->first_name . ' ' . $promoter->last_name,
            'email'             => $promoter->email,
            'phone_no'          => $promoter->phone_no,
            //Admin detail
            'admin_name'        => $admin_details->first_name . ' ' . $admin_details->last_name,
            'admin_email'       => $admin_details->email,
            'admin_phone_no'    => $admin_details->phone_no,
            //Event detail
            'event_title'       => $event_details->event_title,
            'event_category'    => $event_details->category->name,
            'organizer'         => $event_details->organizer,
            'venue'             => $event_details->venue,
            'address'           => $event_details->address,
            'city'              => $event_details->city,
            'zipcode'           => $event_details->zipcode,
            'start_date'        => $event_details->start_date,
            'end_date'          => $event_details->end_date,
            'start_time'        => $event_details->start_time,
            'end_time'          => $event_details->end_time,
            'description'       => $event_details->description,
        ];
        if (!isset($getData)) {
            $save = PromoterAccess::create(
                [
                    'order_no'              => $charge->id,
                    'admin_id'              => $admin_details->id,
                    'event_id'              => $request->event_id,
                    'event_created_by'      => $request->event_created_by,
                    'promoter_id'           => Auth::user()->id,
                    'date'                  => date('Y-m-d H:i:s'),
                    'status'                => 0,
                    "amount"                => config('constants.AMOUNT_TO_PROMOTE_EVENT'),
                    'currency'              => $charge->currency ?? 'usd',
                    'payment_status'        => $charge->status,
                    "payment_response"      => json_encode($payment_response),
                ]
            );
            $promoterTamplate   = 'email.promoter-access-mail';
            $adminTamplate   = 'email.admin-received-request-mail';
            $bodyData   = $data;
            $emailToAdmin    = $data['admin_email'];
            $emailToPromoter    = $data['email'];
            $emailFrom  = Config::get('constants.ADMIN_EMAIL2');
            $adminSubject    = 'Access Request from Promoter';
            $promoterSubject    = 'Access Request to Admin';
            $mailType   = 'Promoter Payment';

            Mail::send(
                $promoterTamplate,
                $bodyData,
                function ($message) use ($emailToPromoter, $emailFrom, $promoterSubject, $mailType) {
                    $message->from($emailFrom, $mailType);
                    $message->to($emailToPromoter);
                    $message->subject($promoterSubject);
                }
            );

            Mail::send(
                $adminTamplate,
                $bodyData,
                function ($message) use ($emailToAdmin, $emailFrom, $adminSubject, $mailType) {
                    $message->from($emailFrom, $mailType);
                    $message->to($emailToAdmin);
                    $message->subject($adminSubject);
                }
            );
            return [
                'status'    => 'success',
                'message'   => trans('messages.promoter_access.request_sent'),
            ];
        } else {
            return [
                'status'    => 'error',
                'message'   => trans('messages.promoter_access.already_requested'),
            ];
        }
    }


    /**
     * Handling eventOrderDetails Service
     *
     * @param $id int
     *
     * @return orders
     */
    public function eventOrderDetails($id)
    {
        $order = Order::where('event_id', $id)
            ->where('sender_id', Auth::user()->id)
            ->get();
        $orders = $order->map(
            function ($ord, $key) {
                // $ord->billing_address = json_decode($ord->billing_address);
                $ord->order_details = json_decode($ord->order_details);
                $ord->order_details->event_image = asset('/event-images/' . $ord->order_details->event_image);
                $date = Carbon::createFromFormat('Y-m-d H:i:s', $ord->order_placed_date)
                    ->format('m-d-Y');
                $ord->order_placed_date = $date;
                $ticketsChecked = TicketOrder::where('order_id', $ord->id)
                    ->where('is_checked', 1)
                    ->count();
                $ord->ticketsChecked = $ticketsChecked;
                return $ord;
            }
        );
        return $orders;
    }

    public function promotionalChargeRefund($id, $status)
    {
        $prmotioanalCharge = PromoterAccess::where('event_id', $id)->first()->order_no;
        $event = Event::with('user')->findOrFail($id);
        $event->update([
            'refund_status' => $status
        ]);

        $template = 'email.promotionalChargeRefundNotification';
        $mailData = [
            'email'             => $event->user->email,
            'event_name'        => $event->event_title,
            'promter_name'      => $event->user->first_name,
            'start_date'        => $event->start_date,
            'status'            => $status
        ];
        $bodyData   = ['data' => $mailData];
        $emailTo    = $mailData['email'];
        $emailFrom  = Config::get('constants.ADMIN_EMAIL2');
        $subject    = 'Promotional Charge Refund';
        $mailType   = 'Refund Status';
        Mail::send(
            $template,
            $bodyData,
            function ($message) use ($emailTo, $emailFrom, $subject, $mailType) {
                $message->from($emailFrom, $mailType);
                $message->to($emailTo);
                $message->subject($subject);
            }
        );
        if($status == "2") {
            return [
                "status" =>200,
                "message" => "Refund reqest has been cancelled!"
            ];
        } else {
            $refund_response = $this->initiateRefundAfterCancellingOrders($prmotioanalCharge);
            if ($refund_response['refund_response_status'] === 'succeeded') {
                Log::channel('striperefundlogforpromoters')->info($refund_response['refund_response']);
                return [
                    "status" =>200,
                    "message" => "Refund was initiated successfully!"
                ];
            }
        }
    }
}
