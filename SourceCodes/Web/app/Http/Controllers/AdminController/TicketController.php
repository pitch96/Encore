<?php

namespace App\Http\Controllers\AdminController;

use App\Models\Admin\Event;
use Illuminate\Http\Request;
use App\Services\TicketService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\TicketFormRequest;

class TicketController extends Controller
{
    protected $ticketService;

    public function __construct(TicketService $ticketService)
    {
        $this->ticketService = $ticketService;
    }

    /**
     * View Manage ticket page
     * Get the all ticket from tickets table
     */
    public function manageTickets(Request $request)
    {
        try {
            $tickets = $this->ticketService->allTickets();
            return view('admin.tickets.index', compact('tickets'));
        } catch (\Exception $exception) {
            return Redirect::back()->with('error', $exception->getMessage());
        }
    }

    /**
     * View create ticket page
     * Here we get the all event created by loggedIn user
     */
    public function createTicket()
    {
        try {
            $events = $this->ticketService->getAllActiveEvents();
            return view('admin.tickets.create', compact('events'));
        } catch (\Exception $exception) {
            return Redirect::back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Store Ticket in tickets Table
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
    public function saveTicket(TicketFormRequest $request)
    {
        $request->validated();
        try {
                $response = $this->ticketService->storeTicket($request);
                if ($response['status'] === 'success') {
                    return Redirect::to("/admin/manage/tickets")->with('success', $response['message']);
                } else {
                    return back()->withInput()->with('error', $response['message']);
                }
                $response = $this->ticketService->storeTicket($request);
                if ($response['status'] === 'success') {
                    return Redirect::to("/admin/manage/tickets")->with('success', $response['message']);
                } else {
                    return back()->withInput()->with('error', $response['message']);
                }
        } catch (\Exception $exception) {
            return back()->withInput()->with('error', $exception->getMessage());
        }
    }

    /**
     * Edit Ticket Details
     * @param [int] id
     */
    public function editTicket($id)
    {
        try {
            $response = $this->ticketService->editTicket($id);
            return view('admin.tickets.update', $response);
        } catch (\Exception $exception) {
            return Redirect::to("/admin/manage/tickets")->with('error', $exception->getMessage());
        }
    }

    /**
     * Update ticket by ticket id
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
    public function updateTicket(TicketFormRequest $request, $id)
    {
        $request->validated();
        try {
            $ticket_id = Crypt::decrypt($id);
            $response = $this->ticketService->updateTicket($ticket_id, $request);
            if ($response['status'] === 'success') {
                return Redirect::to("/admin/manage/tickets")->with('success', $response['message']);
            } else {
                return back()->withInput()->with('error', $response['message']);
            }
        } catch (\Exception $exception) {
            return back()->withInput()->with('error', $exception->getMessage());
        }
    }

    /**
     * Delete ticket Details
     * @param [int] id
     */
    public function deleteTicket($id)
    {
        try {
            $this->ticketService->deleteTicket($id);
            return response()->json([
                'status'    => true,
                'message'   => trans('messages.ticket.success.delete')
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'status'    => false,
                'message'   => trans('messages.ticket.error.not_found')
            ]);
        }
    }

    /**
     * Change ticket status
     * @param [int] id
     */
    public function changeStatus($id, $status)
    {
        try {
            $this->ticketService->changeTicketStatus($id, $status);
            return response()->json([
                'status'    => true,
                'message'   => trans('messages.ticket.success.change_status')
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'status'    => false,
                'message'   => trans('messages.ticket.error.not_found')
            ]);
        }
    }
}
