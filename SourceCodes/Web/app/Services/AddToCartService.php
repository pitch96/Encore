<?php

namespace App\Services;

use App\Models\User;
use App\Models\Admin\AddToCart;
use App\Models\Admin\BillingAddress;
use Illuminate\Support\Facades\Auth;

class AddToCartService
{
    /**
     * Add ticket to card service
     * @param [Int] user_id
     * @param [Int] ticket_id
     * @param [Int] ticket_qty
     */
    public function addToCartTicket($request)
    {
        $isUser = User::where('id', $request->user_id)->first();
        if (isset($isUser)) {
            AddToCart::where('user_id', $request->user_id)->delete();
            $save = AddToCart::create([
                'user_id' => $request->user_id,
                'ticket_id' => $request->ticket_id,
                'quantity' => $request->ticket_qty,
            ]);
            return $save;
        } else {
            return null;
        }
    }

    /**
     * Update ticket to card service
     * @param [Int] user_id
     * @param [Int] event_id
     * @param [Int] ticket_id
     * @param [Int] ticket_qty
     * @param [double] total_price
     */
    public function updateCartTicket($request)
    {
        $data = AddToCart::where(['user_id' => $request->user_id, 'ticket_id' => $request->ticket_id])->first();
        if (isset($data)) {
            $data->update([
                'quantity' => $request->ticket_qty,
            ]);
            return [
                'status'    => 'success',
                'message'   => trans('messages.cart_updated'),
                'data'      => $data
            ];
        } else {
            return [
                'status' => 'error',
                'message' => trans('messages.cart_error')
            ];
        }
    }

    /**
     * Checkout Function service
     */
    public function checkoutTicket()
    {
        $cartDatas = AddToCart::where(['user_id' => Auth::user()->id])->with(['ticket', 'ticket.event'])->get();
        $active_address = BillingAddress::where(['user_id' => Auth::user()->id, 'active' => 1])->first();
        $all_address = BillingAddress::where('user_id', Auth::user()->id)->where('user_id', '!=', 1)->get();
        if (count($cartDatas) > 0) {
            $cartDatas[0]->ticket->event->event_image = asset('/event-images/' . $cartDatas[0]->ticket->event->image);
        } else {
            $cartDatas = [];
        }
        return [
            'cartDatas'         => $cartDatas,
            'active_address'    => $active_address,
            'all_address'       => $all_address
        ];
    }

    public function calculateCart(){
        $cart_items = [];
        $cartDatas = AddToCart::where(['user_id' => Auth::user()->id])->with(['ticket', 'ticket.event'])->get();
        foreach ($cartDatas as $key => $item) {
            array_push($cart_items, $item->id);
        }
        return [
            'cart_items' => implode(',', $cart_items)
        ];
    }
    /**
     * get cart data service.
     * @param['id'] int
     */
    public function getCartTicket($id)
    {
        return AddToCart::where(['id' => $id, 'user_id' => Auth::user()->id])->first();
    }
}
