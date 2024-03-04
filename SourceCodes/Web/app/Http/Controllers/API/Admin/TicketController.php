<?php

namespace App\Http\Controllers\API\Admin;

use Carbon\Carbon;
use App\Models\Admin\Event;
use App\Models\Admin\Ticket;
use Illuminate\Http\Request;
use App\Services\TicketService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use App\Http\Requests\API\TicketFormRequest;
use App\Http\Traits\SuccessAndFailedResponseTrait;



class TicketController extends Controller
{
    use SuccessAndFailedResponseTrait;
    protected $ticketService;
    public function __construct(TicketService $ticketService)
    {
        $this->ticketService = $ticketService;
    }

    /**
     * View Manage Tickets
     * Here we get all the ticket on the basis of loggedIn user from ticket table
     */

    /**
     *  @OA\Get(
     *      path="/api/admin/tickets",
     *      tags={"Admin APIs"},
     *      security={
     *          {"bearerAuth": {}},
     *      },
     *      summary="Get all Tickets",
     *      operationId="all-tickets",
     *      @OA\Parameter(
     *          name="tickets",
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

    public function manageTickets(Request $request)
    {
        try {
            $params = $request->tickets;
            $response = $this->ticketService->allTickets($request);
            if (count($response) > 0) {
                return $this->successResponse(200, true, trans('messages.record_found'), $response);
            } else {
                return $this->successResponse(200, true, trans('messages.record_not_found'), []);
            }
        } catch (\Exception $exception) {
            return $this->failedResponse(400, false, trans('messages.ticket.error.not_found'));
        }
    }


    /**
     * Store event in events Table
     * @param [int] user_id
     * @param [int] event_id
     * @param [string] ticket_title
     * @param [string] ticket_type
     * @param [string] total_qty
     * @param [string] ticket_price
     * @param [date] start_date
     * @param [date] end_date
     * @param [string] start_time
     * @param [string] end_time
     */

     /**
     *  @OA\Post(
     *      path="/api/admin/ticket",
     *      tags={"Admin APIs"},
     *      security={
     *          {"bearerAuth": {}},
     *      },
     *      summary="Save Ticket",
     *      operationId="save-ticket",
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
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="ticket_title",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="ticket_type",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="total_qty",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="ticket_price",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="integer"
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
     *          name="end_time",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="string",
     *              format="time"
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
    public function saveTicket(TicketFormRequest $request)
    { 
        try {
            $current_timestamp = strtotime(Carbon::now()->format('Y-m-d H:i'));
            $end_timestamp = strtotime($request->end_date . ' ' . date("H:i", strtotime($request->end_time)));
            if ($end_timestamp <= $current_timestamp) {
                return $this->failedResponse(400, false, trans('messages.ticket.error.date_error'));
            }
            $response = $this->ticketService->storeTicketAPI($request);
            if ($response['status'] !== 'error') {
                return $this->successResponse(200, true, trans('messages.ticket.success.save'), $response);
            }else {
                return $this->failedResponse(400, false, trans('messages.ticket.error.save'), $response);
            }
        } catch (\Exception $exception) {
            return $this->failedResponse(400, false, trans('messages.ticket.error.save'), $response);
        }
    }



    /**
     * View single Tickets by Id.
     * Here we get the ticket on the basis of ticket id from ticket table.
     */

    /**
     *  @OA\Get(
     *      path="/api/admin/ticket/{id}",
     *      tags={"Admin APIs"},
     *      security={
     *          {"bearerAuth": {}},
     *      },
     *      summary="Get single Tickets",
     *      operationId="single-tickets",
     *      @OA\Parameter(
     *          name="id",
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

     public function getTicket($id)
     {
         try {
             $response = $this->ticketService->editTicket(Crypt::encrypt($id));
             if (count($response) > 0) {
                 return $this->successResponse(200, true, trans('messages.record_found'), $response);
             } else {
                 return $this->successResponse(200, true, trans('messages.record_not_found'), []);
             }
         } catch (\Exception $exception) {
             return $this->failedResponse(400, false, trans('messages.ticket.error.not_found'));
         }
     }
 
    /**
     * Update Tickets By Id.
     * Here we update the ticket on the basis of ticket id from ticket table.
     */

    /**
     *  @OA\PUT(
     *      path="/api/admin/ticket",
     *      tags={"Admin APIs"},
     *      security={
     *          {"bearerAuth": {}},
     *      },
     *      summary="Upadete Ticket",
     *      operationId="update-ticket",
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
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="ticket_title",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="ticket_type",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="total_qty",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="ticket_price",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="integer"
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
     *          name="end_time",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="string",
     *              format="time"
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
    public function updateTicket(TicketFormRequest $request, $id)
    {
        try {
            $current_timestamp = strtotime(Carbon::now()->format('Y-m-d H:i'));
            $end_timestamp = strtotime($request->end_date . ' ' . date("H:i", strtotime($request->end_time)));
            if ($end_timestamp <= $current_timestamp) {
                return $this->failedResponse(400, false, trans('messages.ticket.error.date_error'));
            }
            $response = $this->ticketService->updateTicket($id, $request);
            if ($response) {
                return $this->successResponse(200, true, trans('messages.ticket.success.update'), $response);
            } else {
                return $this->failedResponse(400, false, trans('messages.ticket.error.save'));
            }
        } catch (\Exception $exception) {
            return $this->failedResponse(400, false, trans('messages.ticket.error.save'));
        }
    }

    /**
    * Delete Tickets By Id.
    * Here we delete the ticket on the basis of ticket id from ticket table.
    */
    /**
     *  @OA\DELETE(
     *      path="/api/admin/ticket/",
     *      tags={"Admin APIs"},
     *      security={
     *          {"bearerAuth": {}},
     *      },
     *      summary="Delete Ticket",
     *      operationId="delete-ticket",
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
     *          name="id",
     *          in="query",
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
    public function deleteTicket($id)
    { 
        try {
            $response = $this->ticketService->deleteTicket(Crypt::encrypt($id));
            if ($response) {
                return $this->successResponse(200, true, trans('messages.ticket.success.delete'), $response);
            } else {
                return $this->failedResponse(400, false, trans('messages.ticket.error.delete'));
            }
        } catch (\Exception $exception) {
            return $this->failedResponse(400, false, trans('messages.ticket.error.delete'));
        }
    }

 /**
    * Change Tickets Status By Id.
    * Here we delete the ticket on the basis of ticket id from ticket table.
    */

    /**
     *  @OA\get(
     *      path="/api/admin/ticket/",
     *      tags={"Admin APIs"},
     *      security={
     *          {"bearerAuth": {}},
     *      },
     *      summary="Change Ticket status ",
     *      operationId="change-ticket status",
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
     *          name="id",
     *          in="query",
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
            $response = $this->ticketService->changeTicketStatus(Crypt::encrypt($id), $status);
           
            if ($response) {
                return $this->successResponse(200, true, trans('messages.ticket.success.change_status'), []);
            } else {
                return $this->failedResponse(400, false, trans('messages.ticket.error.ticket_error'));
            }
        } catch (\Exception $exception) {
            return $this->failedResponse(400, false, trans('messages.ticket.error.not_found'));
        }
    }

 /**
    * Finding all the tickets and the guest count fo the specific events.
    * @param [int] event_id
    */

    /**
     * @OA\get(
     *      path="/api/totalTicket/{event_id}",
     *      tags={"Admin APIs"},
     *      security={
     *          {"bearerAuth": {}},
     *      },
     *      summary="All tickets and Guest Count",
     *      operationId="all-ticket-&-guest-count",
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
     */
    public function totalTicekts($event_id)
    {
        try {
            $response = $this->ticketService->totalTicketNumbers($event_id);
            if($response['total_tickets_sold'] > 0){
                return $this->successResponse(200, true, trans('messages.record_found'), $response);
            } else {
                return $this->failedResponse(400, false, 'No tickets sold for this event');
            }
        } catch (\Exception $exception) {
            return $this->failedResponse(400, false, $exception->getMessage());
        } 
    }
}
