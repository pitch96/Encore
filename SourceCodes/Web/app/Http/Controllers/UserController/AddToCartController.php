<?php

namespace App\Http\Controllers\UserController;

use Illuminate\Http\Request;
use App\Services\AddToCartService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class AddToCartController extends Controller
{
    protected $addToCartService;
    public function __construct(AddToCartService $addToCartService)
    {
        $this->addToCartService = $addToCartService;
    }
    /**
     * Add ticket to card
     * @param [Int] user_id
     * @param [Int] ticket_id
     * @param [Int] ticket_qty
     */
    public function addToCart(Request $request)
    {
        try {
            if($request->remaining_tickets >= 0) {
                $save = $this->addToCartService->addToCartTicket($request);
                if ($save) {
                    return response()->json([
                        'status' => 1,
                        'data' => $save
                    ]);
                } else {
                    return response()->json([
                        'status' => 0,
                        'message' => trans('messages.admin_user.error.not_found'),
                    ]);
                }
            }
        } catch (\Exception $exception) {
            return response()->json([
                'status' => 0,
                'message' => $exception->getMessage(),
            ]);
        }
    }

    /**
     * Update ticket to card
     * @param [Int] user_id
     * @param [Int] event_id
     * @param [Int] ticket_id
     * @param [Int] ticket_qty
     * @param [double] total_price
     */
    public function updateCart(Request $request)
    {
        try {
            $response = $this->addToCartService->updateCartTicket($request);
            if ($response['status'] === 'success') {
                return response()->json([
                    'status' => 1,
                    'message' => $response['message']
                ]);
            } else {
                return response()->json([
                    'status' => 0,
                    'message' => $response['message']
                ]);
            }
        } catch (\Exception $exception) {
            return response()->json([
                'status' => 0,
                'message' => $exception->getMessage(),
            ]);
        }
    }

    /**
     * Checkout Function
     */
    public function checkout()
    {
        try {
            $response = $this->addToCartService->checkoutTicket();
            return view('frontend.checkout2', $response);
        } catch (\Exception $exception) {
            return Redirect::back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Checkout Function
     */
    public function checkout2()
    {
        try {
            $response = $this->addToCartService->checkoutTicket();
            return view('frontend.checkout2', $response);
        } catch (\Exception $exception) {
            return Redirect::back()->with('error', $exception->getMessage());
        }
    }

    /**
     * calculate cart
     */
    public function calculateCart()
    {
        try {
            $response = $this->addToCartService->calculateCart();
            return response()->json($response);
        } catch (\Exception $exception) {
            return Redirect::back()->with('error', $exception->getMessage());
        }
    }

    /**
     * delete cart data.
     * @param['id'] int
     */
    public function deleteCartItem($id)
    {
        try {
            $response = $this->addToCartService->getCartTicket($id);
            if (isset($response)) {
                $response->delete();
                return response()->json([
                    'status' => 1,
                ]);
            } else {
                return response()->json([
                    'status' => 0,
                    'message' => trans('messages.cart_not_found'),
                ]);
            }
        } catch (\Exception $exception) {
            return response()->json([
                'status' => 0,
                'message' => trans('messages.cart_not_found'),
            ]);
        }
    }
}
