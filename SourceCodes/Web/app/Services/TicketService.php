<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Admin\Order;
use App\Models\Admin\Event;
use App\Models\TicketOrder;
use App\Models\Admin\Ticket;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use App\Http\Traits\SuccessAndFailedResponseTrait;

/**
 *For Managing all Ticket related services
 */
class TicketService
{
    /**
     * View Manage ticket page service
     * Get the all ticket from tickets table
     */
    public function allTickets()
    {
        $collection = Ticket::where('user_id', Auth::user()->id)->with('event')->orderBy('id', 'desc')->get();
        $tickets = $collection->map(function ($ticket, $key) {
            $current_timestamp = strtotime(Carbon::now()->format('Y-m-d H:i'));
            $end_timestamp = strtotime($ticket->end_date . ' ' . date("H:i", strtotime($ticket->end_time)));
            $status = '';
            if ($end_timestamp < $current_timestamp) {
                $status = 'Expired';
                $ticket->status = 0;
            } else {
                $status = 'Running';
            }
            $ticket['ticket_status'] = $status;
            return $ticket;
        });
        return $tickets;
    }

    /**
     * get all active events service
     */
    public function getAllActiveEvents()
    {
        $events = Event::where('user_id', Auth::user()->id)
            ->where('isCancelled', 0)
            ->allEvents()
            ->get();
        return $events;
    }

    /**
     * Store Ticket API in tickets Table service
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
    public function storeTicketAPI($request)
    {
        $data = [];
        $current_timestamp = strtotime(Carbon::now()->format('Y-m-d H:i'));
        $end_timestamp = strtotime($request->end_date . ' ' . date("H:i", strtotime($request->end_time)));
        if ($request->total_qty < 1) {
            return [
                'status'    => 'error',
                'message'   => trans('messages.ticket.error.not_less_then_1'),
            ];
            return back()->withInput()->with('error', trans('messages.ticket.error.not_less_then_1'));
        }
        if ($request->ticket_type == 'Paid' && $request->ticket_price < 1) {
            return [
                'status'    => 'error',
                'message'   => trans('messages.ticket.error.price_error'),
            ];
            return back()->withInput()->with('error', trans('messages.ticket.error.price_error'));
        }
        if ($request->end_date === null) {
            return [
                'status'    => 'error',
                'message'   => trans('messages.ticket.error.end_date_error'),
            ];
            return back()->withInput()->with('error', trans('messages.ticket.error.end_date_error'));
        }
        if ($end_timestamp > $current_timestamp) {
            $data = [
                'user_id'       => Auth::user()->id,
                'event_id'      => $request->event_id,
                'ticket_title'  => $request->ticket_title,
                'ticket_type'   => $request->ticket_type,
                'quantity'      => $request->total_qty,
                'price'         => $request->ticket_type !== "Free" ? $request->ticket_price : 0,
                'end_date'      => $request->end_date,
                'end_time'      => $request->end_time,
            ];
        } else {
            return [
                'status'    => 'error',
                'message'   => trans('messages.ticket.error.date_error'),
            ];
            return back()->withInput()->with('error', trans('messages.ticket.error.date_error'));
        }
        Ticket::insert($data);
        return [
            'status'    => 'success',
            'message'   => trans('messages.ticket.success.save'),
        ];
    }



    /**
     * Store Ticket in tickets Table service
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
    public function storeTicket($request)
    {
        $data = [];
        if (count($request->ticket_title) > 0) {
            foreach ($request->ticket_title as $key => $ticket_title) {
                $current_timestamp = strtotime(Carbon::now()->format('Y-m-d H:i'));
                $end_timestamp = strtotime($request->end_date[$key] . ' ' . date("H:i", strtotime($request->end_time[$key])));
                if ($request->total_qty[$key] < 1) {
                    return [
                        'status'    => 'error',
                        'message'   => trans('messages.ticket.error.not_less_then_1'),
                    ];
                    return back()->withInput()->with('error', trans('messages.ticket.error.not_less_then_1'));
                }
                if ($request->end_date[$key] === null) {
                    return [
                        'status'    => 'error',
                        'message'   => trans('messages.ticket.error.end_date_error'),
                    ];
                    return back()->withInput()->with('error', trans('messages.ticket.error.end_date_error'));
                }
                if ($request->ticket_type[$key] === 'Paid' && $request->ticket_price[$key] < 1) {
                    return [
                        'status'    => 'error',
                        'message'   => trans('messages.ticket.error.price_error'),
                    ];
                    return back()->withInput()->with('error', trans('messages.ticket.error.price_error'));
                }
                if ($end_timestamp > $current_timestamp) {
                    $data[$key] = [
                        'user_id'       => $request->user_id,
                        'event_id'      => $request->event_id,
                        'ticket_title'  => $ticket_title,
                        'ticket_type'   => $request->ticket_type[$key],
                        'quantity'      => $request->total_qty[$key],
                        'price'         => $request->ticket_type[$key] !== "Free" ? $request->ticket_price[$key] : 0,
                        'end_date'      => $request->end_date[$key],
                        'end_time'      => $request->end_time[$key],
                    ];
                } else {
                    return [
                        'status'    => 'error',
                        'message'   => trans('messages.ticket.error.date_error'),
                    ];
                    return back()->withInput()->with('error', trans('messages.ticket.error.date_error'));
                }
            }
            Ticket::insert($data);
            return [
                'status'    => 'success',
                'message'   => trans('messages.ticket.success.save'),
            ];
        } else {
            return [
                'status'    => 'error',
                'message'   => trans('messages.ticket.error.save'),
            ];
        }
    }


    /**
     * Edit Ticket Details by id service
     * @param [int] id
     */
    public function editTicket($id)
    {
        $events = Event::where('user_id', Auth::user()->id)
                ->allEvents()
                ->get()
                ->pluck('event_title', 'id');
        $ticket = Ticket::findOrFail(Crypt::decrypt($id));
        return ['events' => $events, 'ticket' => $ticket];
    }

    /**
     * Update ticket by ticket id service
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
    public function updateTicket($id, $request)
    {
        $ticket = Ticket::findOrFail($id);
        $current_timestamp = strtotime(Carbon::now()->format('Y-m-d H:i'));
        $end_timestamp = strtotime($request->end_date . ' ' . date("H:i", strtotime($request->end_time)));
        if ($end_timestamp > $current_timestamp) {
            $ticket->update([
                'ticket_title'  => $request->ticket_title,
                'ticket_type'   => $request->ticket_type,
                'quantity'      => $request->total_qty,
                'price'         => $request->ticket_price ?: 0,
                'end_date'      => $request->end_date,
                'end_time'      => $request->end_time,
            ]);
            return [
                'status'    => 'success',
                'message'   => trans('updated'),
                'data'      => $ticket
            ];
        } else {
            return [
                'status'    => 'error',
                'message'   => trans('messages.ticket.error.date_error'),
            ];
        }
    }

    /**
     * Delete ticket Details service
     * @param [int] id
     */
    public function deleteTicket($id)
    {
        return Ticket::findOrFail(Crypt::decrypt($id))->delete();
    }

    /**
     * Change ticket status service
     * @param [int] id
     * @param [int] status
     */
    public function changeTicketStatus($id, $status)
    {
        return Ticket::findOrFail(Crypt::decrypt($id))->update(['status' => $status]);
    }

    public function totalTicketNumbers($id)
    {
        $orders = Order::where('event_id', $id)->get();
        $ticket = 0;
        $guests = 0;
        if($orders->count() > 0){
            foreach ($orders as $order){
                $guests += TicketOrder::where('order_id', $order['id'])->where('is_checked', 1)->count();
                $ticket += $order['total_quantity']; 
            }
            $totalTickets = $ticket;
            $guestsArrived = $guests;
        } else {
            $guestsArrived = $guests;
            $totalTickets = $ticket;
        }
        $response = [
            'total_tickets_sold' => $totalTickets,
            'guests_arrived' => $guestsArrived,
            'tickets_left' => $totalTickets - $guestsArrived
        ];
        return $response;
    }
}
