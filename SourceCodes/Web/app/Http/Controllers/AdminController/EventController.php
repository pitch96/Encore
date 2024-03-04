<?php

namespace App\Http\Controllers\AdminController;

use Carbon\Carbon;
use PSpell\Config;
use App\Models\Admin\Event;
use Illuminate\Http\Request;
use App\Services\EventService;
use App\Models\Admin\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use App\Models\PromotionalEventCharge;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\EventFormRequest;
use Exception;

class EventController extends Controller
{
    protected $eventService;

    public function __construct(EventService $eventService)
    {
        $this->eventService = $eventService;
    }

    /**
     * View Manage Event Page
     * Here we get all the events on the basis of loggedIn user from events table
     */
    public function manageEvents(Request $request)
    {
        try {
            $paybleAmount = PromotionalEventCharge::first()->charge;
            $params = $request->events;
            $events = $this->eventService->allEvents($request);
            return view('admin.events.index', compact('events', 'params', 'paybleAmount'));
        } catch (\Exception $exception) {
            return Redirect::back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Return events of the logged in promoter/admin with information
     * Here we get data for events like total tickets, revenue and guest count for the events
     */
    public function eventDetailWithOrders(Request $request)
    {
        try {
            $params = $request->events;
            $events = $this->eventService->eventOrderAndDetails($request);
            if($events != null){
                return view('admin.events.event-details', compact('events', 'params'));
            } else {
                return view('admin.events.event-details', compact('params'));
            }
        } catch (\Exception $exception) {
            return Redirect::back()->with('error', $exception->getMessage());
        }
    }

    /**
     * View create new event page
     */
    public function createEvent(Request $request)
    {
        try {
            $categories = Category::where('status', 1)->get();
            return view('admin.events.create', compact('categories'));
        } catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Store event in events Table
     * @param [int] user_id
     * @param [int] category_id
     * @param [string] event_title
     * @param [string] organizer
     * @param [string] venue
     * @param [string] address
     * @param [string] city
     * @param [string] zipcode
     * @param [date] start_date
     * @param [date] end_date
     * @param [string] start_time
     * @param [string] end_time
     * @param [string] description
     * @param [string] image
     */
    public function saveEvent(EventFormRequest $request)
    {
        $request->validated();
        try {
            $current_timestamp = strtotime(Carbon::now()->format('Y-m-d H:i'));
            $end_timestamp = strtotime($request->end_date . ' ' . date("H:i", strtotime($request->end_time)));
            $start_timestamp = strtotime($request->start_date . ' ' . date("H:i", strtotime($request->start_time)));
            if ($end_timestamp <= $current_timestamp) {
                return back()->withInput()->with('error', trans('messages.event.error.date_error'));
            }
            if ($end_timestamp <= $start_timestamp) {
                return back()->withInput()->with('error', trans('messages.event.error.start_date_error'));
            }
            $event = $this->eventService->storeEvent($request);
            if ($event) {
                return Redirect::to("/admin/manage/events")->with('success', trans('messages.event.success.save'));
            } else {
                return back()->withInput()->with('error', trans('messages.event.error.save'));
            }
        } catch (\Exception $exception) {
            return back()->withInput()->with('error', $exception->getMessage());
        }
    }

    /**
     * Edit event Details
     * @param [int] id
     */
    public function editEvent(Request $request, $id)
    {
        try {
            $categories = Category::where('status', 1)->get();
            $event = Event::findOrFail(Crypt::decrypt($id));
            $event->image = asset('/event-images/'.$event->image);
            $event->venue_image = asset('/event-images/'.$event->venue_image);
            return view('admin.events.update', compact('event', 'categories'));
        } catch (\Exception $exception) {
            return Redirect::back()->with('error', trans('messages.event.error.not_found'));
        }
    }

    /**
     * Update event by event id
     * @param [int] category_id
     * @param [string] event_title
     * @param [string] organizer
     * @param [string] venue
     * @param [string] address
     * @param [string] city
     * @param [string] zipcode
     * @param [date] start_date
     * @param [date] end_date
     * @param [string] start_time
     * @param [string] end_time
     * @param [string] description
     * @param [string] image
     */
    public function updateEvent(EventFormRequest $request, $id)
    {
        $request->validated();
        try {
            $current_timestamp = strtotime(Carbon::now()->format('Y-m-d H:i'));
            $end_timestamp = strtotime($request->end_date . ' ' . date("H:i", strtotime($request->end_time)));
            $start_timestamp = strtotime($request->start_date . ' ' . date("H:i", strtotime($request->start_time)));
            if ($end_timestamp <= $current_timestamp) {
                return back()->withInput()->with('error', trans('messages.event.error.date_error'));
            }
            if ($end_timestamp <= $start_timestamp) {
                return back()->withInput()->with('error', trans('messages.event.error.start_date_error'));
            }
            $event = $this->eventService->updateEvent($id, $request);
            if ($event) {
                return Redirect::to("/admin/manage/events")->with('success', trans('messages.event.success.update'));
            } else {
                return back()->withInput()->with('error', trans('messages.event.error.update'));
            }
        } catch (\Exception $exception) {
            return back()->withInput()->with('error', trans('messages.event.error.not_found'));
        }
    }

    /**
     * Delete event Details
     * @param [int] id
     */
    public function deleteEvent($id)
    {
        try {
            DB::beginTransaction();
            $this->eventService->deleteEvent($id);
            DB::commit();
            return response()->json([
                'status' => true,
                'message' => trans('messages.event.success.delete')
            ]);
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $exception->getMessage()
            ]);
        }
    }

    /**
     * Cancel Event Functionality
     * @param[int] id
     */
    public function cancelEvent(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $event_id = Crypt::decrypt($id);
            $response = $this->eventService->cancelEvent($request, $event_id);
            DB::commit();
            return response()->json($response);
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $exception->getMessage()
            ]);
        }
    }

    /**
     * Return data for the cancelled event listings
     */
    public function cancelledEvent(Request $request)
    {
        try {
            $params = $request->events;
            $events = $this->eventService->allCancelledEvents($request);
            return view('admin.events.cancelled-events', compact('events', 'params'));
        } catch (\Exception $exception) {
            return Redirect::back()->with('error', $exception->getMessage());
        }
    }

    /**
     * All cancelled events listing for promoters
     */
    public function myCancelledEvents()
    {
        try {
            $events = $this->eventService->myCancelledEventsList();
            return view('admin.events.myCancelled-events', compact('events'));
        } catch (\Exception $exception) {
            return Redirect::back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Change event status
     * 
     * @param [int] id
     */
    public function changeStatus($id, $status)
    {
        try {
            $response = $this->eventService->changeEventStatus($id, $status);
            if ($response['status'] === 'success') {
                return response()->json([
                    'status'    => true,
                    'message'   => trans('messages.event.success.change_status')
                ]);
            } else {
                return response()->json([
                    'status'    => false,
                    'message'   => trans('messages.event.error.ticket_error')
                ]);
            }
        } catch (\Exception $exception) {
            return response()->json([
                'status'    => false,
                'message'   => trans('messages.event.error.not_found')
            ]);
        }
    }

    /**
     * Change the popularity status for the event
     * 
     * @param [int] id
     * @param [int] status
     */
    public function changePopularityStatus($id, $status)
    {
        try{
            $event_id = Crypt::decrypt($id);
            $response = $this->eventService->changeEventPopularityStatus($event_id, $status);
            if ($response['status'] === 'success') {
                return response()->json([
                    'status'    => true,
                    'message'   => trans('Event popularity status changed.')
                ]);
            }
        } catch (\Exception $exception) {
            return response()->json([
                'status' => false,
                'message' => trans('messages.event.error.not_found')
            ]);
        }
    }

    // Event detail function
    /**
     * Event detail page get event by id
     * @param [int] id
     */
    public function eventDetail($id)
    {
        try {
            $data = $this->eventService->getEventById($id);
            return view("admin.events.detail", $data);
        } catch (\Exception $exception) {
            return Redirect::back()->with('error', trans('messages.event.error.not_found'));
        }
    }

    /**
     * Promoter requested to admin for an event
     * @param['event_id'] int
     * @param['event_created_by'] date
     */
    public function promoterAccess(Request $request)
    {
        try {
            $data = $this->eventService->accessRequestForEventByPromoter($request);
            if ($data) {
                return response()->json([
                    'status'    => 1,
                    'message'   => trans('messages.promoter_access.request_sent')
                ]);
            } else {
                return response()->json([
                    'status'    => 1,
                    'message'   => trans('messages.promoter_access.already_requested')
                ]);
            }
        } catch (\Exception $exception) {
            return response()->json([
                'status'    => 0,
                'message'   => $exception->getMessage(),
            ]);
        }
    }

    /**
     * Get all Promotion list data with event detail, category and promoter detail on admin
     * @param['status']0 for Pending, 1 for Approved, 2 for Reject
     * @param['promotion_event_id']
     */
    public function promotionList(Request $request)
    {
        try {
            $params = $request->events;
            $promotionEvents = $this->eventService->promoterRequestToAdminForPromoteEvent($request);
            return view('admin.events.promotion-list', compact('promotionEvents', 'params'));
        } catch (\Exception $exception) {
            return Redirect::back()->with('error', $exception->getMessage());
        }
    }
    
    /**
     * Admin manage the promoter access
     * @param['status']0 for Pending, 1 for Approved, 2 for Reject
     * @param['promotion_event_id']
     */
    public function promotionAction($status, $promotion_event_id)
    {
        try {
            $message = $this->eventService->adminActionOnPromoterEventRequest($status, Crypt::decrypt($promotion_event_id));
            return response()->json([
                'status'    => 1,
                'message'   => $message
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'status'    => 0,
                'message'   => $exception->getMessage()
            ]);
        }
    }

    /**
     * Stripe Payment form, for promoter
     * @param['event_id'] int
     * @param['creater_id'] int
     */
    public function getAccess($event_id, $creater_id)
    {
        try {
            $paybleAmount = PromotionalEventCharge::first()->charge;
            $event_id = Crypt::decrypt($event_id);
            $creater_id = Crypt::decrypt($creater_id);
            return view('admin.payment.card-detail-form', compact('paybleAmount', 'event_id', 'creater_id'));
        } catch (\Exception $exception) {
            return Redirect::back()->with('error', $exception->getMessage());
        }
    }


    /**
     * handling payment with POST
     */
    public function handlePost(Request $request)
    {
        try {
            $paybleAmount = PromotionalEventCharge::first()->charge;
            Log::channel('stripepaymentlogforpromoter')->info($request->all());
            if ($paybleAmount > (float)str_replace('$', '', $request->payable_amount)) {
                return Redirect::to('admin/event/detail/'.Crypt::encrypt($request->event_id))
                ->withError(trans('messages.insufficient_amount'). $paybleAmount);
            }
            if ($paybleAmount < (float)str_replace('$', '', $request->payable_amount)) {
                return Redirect::to('admin/event/detail/'.Crypt::encrypt($request->event_id))
                ->withError(trans('messages.extra_amount'). $paybleAmount);
            }
            $response = $this->eventService->promoterPayForEventAccess($request);
            switch ($response['status']) {
                case "success":
                    return Redirect::to('admin/event/detail/'.Crypt::encrypt($request->event_id))
                    ->withSuccess($response['message']);
                case "error":
                    return Redirect::to('admin/event/detail/'.Crypt::encrypt($request->event_id))
                    ->withError($response['message']);
                case "fail":
                    return Redirect::to('admin/event/detail/'.Crypt::encrypt($request->event_id))
                    ->withError($response['message']);
                default:
                    return Redirect::to('admin/event/detail/'.Crypt::encrypt($request->event_id));
            }
        } catch (\Stripe\Exception\CardException $e) {
            $payment_response = $this->failedPaymentResponse($e);
            Log::channel('stripepaymentlogforpromoter')->info($payment_response);
            return Redirect::to('admin/event/detail/'.Crypt::encrypt($request->event_id))
            ->withError($e->getError()->message);
        } catch (\Exception $e) {
            return Redirect::to('admin/event/detail/'.Crypt::encrypt($request->event_id))
            ->withError($e->getMessage());
        }
    }

    public function returnOrderDetails($id)
    {
        try {
            $order_data = $this->eventService->eventOrderDetails(Crypt::decrypt($id));
            return view('admin.events.event-orderDetails', compact('order_data'));
        } catch (\Exception $exception) {
            return Redirect::back()->with('error', $exception->getMessage());
        }
    }

    public function refundPromtionalCharge($id, $status)
    {
        try {
            $event_id = Crypt::decrypt($id);
            $response= $this->eventService->promotionalChargeRefund($event_id,$status);
            return response()->json($response);
        } catch (\Exception $exception) {
            return response()->json([
                'status' => 400,
                'message' => $exception->getMessage()
            ]);
        }
    }
}
