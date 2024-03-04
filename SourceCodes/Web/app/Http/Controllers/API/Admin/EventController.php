<?php

namespace App\Http\Controllers\API\Admin;

use Carbon\Carbon;
use App\Models\Admin\Event;
use Illuminate\Http\Request;
use App\Models\Admin\Category;
use App\Services\EventService;
use App\Services\AdminService;
use Illuminate\Support\Facades\DB;
use App\Models\Admin\StripeAccount;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use App\Models\PromotionalEventCharge;
use App\Http\Requests\API\EventFormRequest;
use App\Http\Traits\SuccessAndFailedResponseTrait;

class EventController extends Controller
{
    use SuccessAndFailedResponseTrait;
    protected $eventService, $adminService;
    public function __construct(EventService $eventService, AdminService $adminService)
    {
        $this->eventService = $eventService;
        $this->adminService = $adminService;
    }

    /**
     * View Manage Event Page
     * Here we get all the events on the basis of loggedIn user from events table
     */

     /**
     *  @OA\Get(
     *      path="/api/admin/events",
     *      tags={"Admin APIs"},
     *      security={
     *          {"bearerAuth": {}},
     *      },
     *      summary="Get all Events",
     *      operationId="all-events",
     *      @OA\Parameter(
     *          name="events",
     *          in="query",
     *          required=false,
     *          @OA\Schema(
     *              type="string",
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="not found"
     *      ),
     *  )
     **/

    public function manageEvents(Request $request)
    {
        try {
            $response = $this->eventService->allEvents($request);
            if (count($response) > 0) {
                return $this->successResponse(200, true, trans('messages.record_found'), $response);
            } else {
                return $this->successResponse(200, true, trans('messages.record_not_found'), []);
            }
        } catch (\Exception $exception) {
            return $this->failedResponse(400, false, trans('messages.event.error.not_found'));
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

     /**
     *  @OA\Post(
     *      path="/api/admin/event",
     *      tags={"Admin APIs"},
     *      security={
     *          {"bearerAuth": {}},
     *      },
     *      summary="Save Event",
     *      operationId="save-event",
     *      @OA\MediaType(mediaType="multipart/form-data"),
     *      @OA\Parameter(
    *           name="accept",
    *           in="header",
    *           @OA\Schema(
    *               type="string",
    *               default="multipart/form-data"
    *           )
    *       ),
     *      @OA\Parameter(
     *          name="category_id",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="event_title",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="organizer",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="venue",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="address",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="city",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="zipcode",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="start_date",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="string",
     *              format="date"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="end_date",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="string",
     *              format="date"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="start_time",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="string",
     *              format="time"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="end_time",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="string",
     *              format="time"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="description",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\RequestBody(
    *           @OA\MediaType(
    *               mediaType="multipart/form-data",
    *               @OA\Schema(
    *                   type="object",
    *                   @OA\Property(
    *                       property="image",
    *                       type="array",
    *                       @OA\Items(
    *                           type="string",
    *                           format="binary",
    *                       ),
    *                   ),
    *               ),
    *           )
    *       ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="not found"
     *      ),
     *  )
     **/
    public function saveEvent(EventFormRequest $request)
    {
        $request->validated();
        try {
            $current_timestamp = strtotime(Carbon::now()->format('Y-m-d H:i'));
            $end_timestamp = strtotime($request->end_date . ' ' . date("H:i", strtotime($request->end_time)));
            $start_timestamp = strtotime($request->start_date . ' ' . date("H:i", strtotime($request->start_time)));
            if ($end_timestamp <= $current_timestamp) {
                return $this->failedResponse(400, false, trans('messages.event.error.date_error'));
            }
            if ($end_timestamp <= $start_timestamp) {
                return $this->failedResponse(400, false, trans('messages.event.error.start_date_error'));
            }
            $response = $this->eventService->storeEvent($request);
            if ($response) {
                return $this->successResponse(200, true, trans('messages.event.success.save'), $response);
            } else {
                return $this->failedResponse(400, false, trans('messages.event.error.save'));
            }
        } catch (\Exception $exception) {
            return $this->failedResponse(400, false, trans('messages.event.error.save'));
        }
    }

    /**
     * Edit event Details
     * @param [int] id
     */

     /**
     *  @OA\Get(
     *      path="/api/admin/event/{event_id}",
     *      tags={"Admin APIs"},
     *      security={
     *          {"bearerAuth": {}},
     *      },
     *      summary="Get Event by Id",
     *      operationId="event-by-id",
     *      @OA\Parameter(
     *          name="event_id",
     *          in="path",
     *          required=true,
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="not found"
     *      ),
     *  )
     **/

    public function editEvent($id)
    {
        try {
            $response = Event::findOrFail($id);
            $response->setAttribute('event_category_name', $response->category->name);
            $response->image = asset('/event-images/'.$response->image);
            if (isset($response)) {
                return $this->successResponse(200, true, trans('messages.record_found'), $response);
            } else {
                return $this->failedResponse(400, false, trans('messages.record_not_found'));
            }
        } catch (\Exception $exception) {
            return $this->failedResponse(400, false, trans('messages.record_not_found'));
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

     /**
     *  @OA\Put(
     *      path="/api/admin/event/{event_id}",
     *      tags={"Admin APIs"},
     *      security={
     *          {"bearerAuth": {}},
     *      },
     *      summary="Update Event",
     *      operationId="update-event",
     *      @OA\MediaType(mediaType="multipart/form-data"),
     *      @OA\Parameter(
    *           name="accept",
    *           in="header",
    *           @OA\Schema(
    *               type="string",
    *               default="multipart/form-data"
    *           )
    *       ),
     *      @OA\Parameter(
     *          name="event_id",
     *          in="path",
     *          required=true,
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="category_id",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="event_title",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="organizer",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="venue",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="address",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="city",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="zipcode",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="start_date",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="string",
     *              format="date"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="end_date",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="string",
     *              format="date"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="start_time",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="string",
     *              format="time"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="end_time",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="string",
     *              format="time"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="description",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\RequestBody(
    *           @OA\MediaType(
    *               mediaType="multipart/form-data",
    *               @OA\Schema(
    *                   type="object",
    *                   @OA\Property(
    *                       property="image",
    *                       type="array",
    *                       @OA\Items(
    *                           type="string",
    *                           format="binary",
    *                       ),
    *                   ),
    *               ),
    *           )
    *       ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="not found"
     *      ),
     *  )
     **/

    public function updateEvent(EventFormRequest $request, $id)
    {
        try {
            $current_timestamp = strtotime(Carbon::now()->format('Y-m-d H:i'));
            $end_timestamp = strtotime($request->end_date . ' ' . date("H:i", strtotime($request->end_time)));
            $start_timestamp = strtotime($request->start_date . ' ' . date("H:i", strtotime($request->start_time)));
            if ($end_timestamp <= $current_timestamp) {
                return $this->failedResponse(400, false, trans('messages.event.error.date_error'));
            }
            if ($end_timestamp <= $start_timestamp) {
                return $this->failedResponse(400, false, trans('messages.event.error.start_date_error'));
            }
            $response = $this->eventService->updateEvent(Crypt::encrypt($id), $request);
            if ($response) {
                return $this->successResponse(200, true, trans('messages.event.success.update'), $response);
            } else {
                return $this->failedResponse(400, false, trans('messages.event.error.update'));
            }
        } catch (\Exception $exception) {
            return $this->failedResponse(400, false, trans('messages.event.error.update'));
        }
    }

    /**
     * Delete event Details
     * @param [int] id
     */

     /**
     *  @OA\Delete(
     *      path="/api/admin/event/{event_id}",
     *      tags={"Admin APIs"},
     *      security={
     *          {"bearerAuth": {}},
     *      },
     *      summary="Delete Event",
     *      operationId="delete-event",
     *      @OA\Parameter(
     *          name="event_id",
     *          in="path",
     *          required=true,
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="not found"
     *      ),
     *  )
     **/

    public function deleteEvent($id)
    {
        try {
            DB::beginTransaction();
            $this->eventService->deleteEvent(Crypt::encrypt($id));
            DB::commit();
            return $this->successResponse(200, true, trans('messages.event.success.delete'), []);
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->failedResponse(400, false, trans('messages.record_not_found'));
        }
    }

    /**
     * Cancel Event Functionality
     * @param[int] id
     */

     /**
     *  @OA\get(
     *      path="/api/admin/cancel/event/{event_id}",
     *      tags={"Admin APIs"},
     *      security={
     *          {"bearerAuth": {}},
     *      },
     *      summary="Cancel Event",
     *      operationId="cancel-event",
     *      @OA\Parameter(
     *          name="event_id",
     *          in="path",
     *          required=true,
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="not found"
     *      ),
     *  )
     **/
    public function cancelEvent($event_id)
    {
        try {
            DB::beginTransaction();
            $response = $this->eventService->cancelEvent($event_id);
            DB::commit();
            return $this->successResponse(200, true, trans('messages.event.success.cancel'), $response);
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $exception->getMessage()
            ]);
        }
    }

    /**
     * Change event status
     * @param [int] id
     * @param [int] status_value
     */
     /**
     *  @OA\get(
     *      path="/api/admin/event/{event_id}/status/{event_status}",
     *      tags={"Admin APIs"},
     *      security={
     *          {"bearerAuth": {}},
     *      },
     *      summary="Change Event Status",
     *      operationId="change-event-status",
     *      @OA\Parameter(
     *          name="event_id",
     *          in="path",
     *          required=true,
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="event_status",
     *          in="path",
     *          required=true,
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="not found"
     *      ),
     *  )
     **/

    public function changeStatus($id, $status)
    {
        try {
            $response = $this->eventService->changeEventStatus(Crypt::encrypt($id), $status);
            if ($response['status'] === 'success') {
                return $this->successResponse(200, true, trans('messages.event.success.change_status'), []);
            } else {
                return $this->failedResponse(400, false, trans('messages.event.error.ticket_error'));
            }
        } catch (\Exception $exception) {
            return $this->failedResponse(400, false, trans('messages.event.error.not_found'));
        }
    }

    /**
     * Change Event Popularity
     * 
     * @param [int] id
     * @param [int] status
     */

     /**
     *  @OA\get(
     *      path="/api/admin/change/popular/status/{id}/{status}",
     *      tags={"Admin APIs"},
     *      security={
     *          {"bearerAuth": {}},
     *      },
     *      summary="Change Popularity Status",
     *      operationId="change-popularity-status",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="status",
     *          in="path",
     *          required=true,
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="not found"
     *      ),
     *  )
     **/
    public function changePopularityStatus($id, $status)
    {
        try {
            $response = $this->eventService->changeEventPopularityStatus($id, $status);
            if ($response['status'] === 'success') {
                return $this->successResponse(200, true, trans('Event popularity status changed.'), []);
            }
        } catch (\Exception $exception) {
            return $this->failedResponse(400, false, trans('messages.event.error.not_found'));
        }
    }

    /**
     * Event detail page get event by id
     * @param [int] id
     */
    public function eventDetail($id)
    {
        try {
            $response = $this->eventService->getEventById(Crypt::encrypt($id));
            if ($response) {
                return $this->successResponse(200, true, trans('messages.event.success.change_status'), $response);
            } else {
                return $this->failedResponse(400, false, trans('messages.event.error.ticket_error'));
            }
        } catch (\Exception $exception) {
            return $this->failedResponse(400, false, trans('messages.event.error.not_found'));
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
            $response = $this->eventService->accessRequestForEventByPromoter($request);
            if ($response) {
                return $this->successResponse(200, true, trans('messages.promoter_access.request_sent'), $response);
            } else {
                return $this->failedResponse(400, false, trans('messages.promoter_access.already_requested'));
            }
        } catch (\Exception $exception) {
            return $this->failedResponse(400, false, $exception->getMessage());
        }
    }

    /**
     * Get all Promotion list data with event detail, category and promoter detail on admin
     */

     /**
     *  @OA\Get(
     *      path="/api/admin/promotion/list",
     *      tags={"Admin APIs"},
     *      security={
     *          {"bearerAuth": {}},
     *      },
     *      summary="Promotional Event List",
     *      operationId="promotional-events",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="not found"
     *      ),
     *  )
     **/
    public function promotionList(Request $request)
    {
        try {
            $response = $this->eventService->promoterRequestToAdminForPromoteEvent($request);
            if ($response != null) {
                return $this->successResponse(200, true, trans('messages.record_found'), $response);
            } else {
                return $this->failedResponse(400, true, trans('messages.record_not_found'), []);
            }
        } catch (\Exception $exception) {
            return $this->failedResponse(400, false, trans('messages.record_not_found'));
        }
    }

    /**
     * Admin manage the promoter access
     * @param['status']0 for Pending, 1 for Approved, 2 for Reject
     * @param['promotion_event_id']
     */

     /**
     *  @OA\get(
     *      path="/api/admin/promotion/action/{status}/{promotion_event_id}",
     *      tags={"Admin APIs"},
     *      security={
     *          {"bearerAuth": {}},
     *      },
     *      summary="Change Promotional Event Status",
     *      operationId="change-promotional-event-status",
     *      @OA\Parameter(
     *          name="status",
     *          in="path",
     *          required=true,
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="promotion_event_id",
     *          in="path",
     *          required=true,
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="not found"
     *      ),
     *  )
     **/
    public function promotionAction($status, $promotion_event_id)
    {
        try {
            $message = $this->eventService->adminActionOnPromoterEventRequest($status, $promotion_event_id);
            return $this->successResponse(200, true, $message, []);
        } catch (\Exception $exception) {
            return $this->failedResponse(400, false, trans('messages.record_not_found'));
        }
    }

    /**
     * Generate the Referral Link
     * @param['event_id']
     */

     /**
     *  @OA\get(
     *      path="/api/CheckStripeAccount/{id}",
     *      tags={"My Profile APIs"},
     *      security={
     *          {"bearerAuth": {}},
     *      },
     *      summary="Generate Referral Link",
     *      operationId="generate-referral-link",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="not found"
     *      ),
     *  )
     **/
    public function CheckStripeAccount($event_id)
    {
        try {
            $user_id = Auth::user()->id;
            $email = Auth::user()->email;
            $stripe_account = StripeAccount::Where('email', $email)->first();
            if($stripe_account == NULL && $user_id != config('constants.ADMIN_TYPE')){
                $response = $this->adminService->connectPromoterWithStripe();
                return $this->successResponse(200, true, [], $response['url']);
            }else{
                $url = url('event/detail/'.$event_id.'/'.Crypt::encrypt($user_id));
                return $this->successResponse(200, true, [], $url);
            }
        } catch (\Exception $exception) {
            return $this->failedResponse(400, false, trans('messages.connect_with_stripe_error'));
        }
    }

    /**
     * Return the all the events with the total ticket and guest count.
     */

    /**
     *  @OA\get(
     *      path="/api/myEventDetails",
     *      tags={"My Profile APIs"},
     *      security={
     *          {"bearerAuth": {}},
     *      },
     *      summary="Get total tickets, revenue and guest count for specific event",
     *      operationId="total-tickets-guest-count-for-event",
     *      @OA\Parameter(
     *          name="events",
     *          in="query",
     *          required=false,
     *          @OA\Schema(
     *              type="string",
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="not found"
     *      ),
     *  )
     **/
    public function eventDetailWithOrders(Request $request)
    { 
        try {
            $response = $this->eventService->eventOrderAndDetails($request);
            if($response != null) {
                return $this->successResponse(200, true, trans('messages.record_found'), $response);
            } else {
                return $this->failedResponse(400, false, trans('messages.record_not_found'));
            }
        } catch (\Exception $exception) {
            return $this->failedResponse(400, false, trans('messages.record_not_found'));
        }
    }

    /**
     * Return the order details for my events.
     * @param['id']
     */

     /**
     *  @OA\get(
     *      path="/api/admin/event/orders/details/{id}",
     *      tags={"My Profile APIs"},
     *      security={
     *          {"bearerAuth": {}},
     *      },
     *      summary="Get orders for specific events",
     *      operationId="orders-of-specific-event",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=false,
     *          @OA\Schema(
     *              type="string",
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="not found"
     *      ),
     *  )
     **/
    public function placedEventOrdersDetails($id)
    {
        try {
            $response = $this->eventService->eventOrderDetails($id);
            return $this->successResponse(200, true, trans('messages.record_found'), $response);
        } catch (\Exception $exception) {
            return $this->failedResponse(400, false, trans('messages.event.error.not_found'));
        }
    }
}
