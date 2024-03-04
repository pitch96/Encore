<?php

namespace App\Http\Controllers\UserController;

use Illuminate\Http\Request;
use App\Services\OrderService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Traits\StripePaymentTrait;

class OrderController extends Controller
{
    use StripePaymentTrait;

    protected $orderService;
    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * Placed cart items
     * Save data in orders
     * Save billing address data in billing_address table
     * Update tickets table
     * Update add_to_carts table
     * @param['int'] user_id
     * @param['string'] cart_id
     * @param['string'] billing_address
     */
    public function placeOrder(Request $request)
    {
        DB::beginTransaction();
        try {
            $response = $this->orderService->orderTickets($request);
            return response()->json([
                'status'    => $response['status'],
                'message'   => $response['message'],
            ]);
        } catch (\Stripe\Exception\CardException $e) {
            $payment_response = $this->failedPaymentResponse($e);
            Log::channel('stripepaymentlogforbuyer')->info($payment_response);
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => $e->getError()->message,
            ]);
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => $exception->getMessage(),
            ]);
        }
    }

    /**
     * Order details after scanning the QR code
     * @param['order_id'] int
     * @param['ticket_no'] int
     */
    public function orderDetails($order_id, $ticket_no)
    {
        try {
            $response = $this->orderService->qrDetails($order_id, $ticket_no);
            return view('frontend/order-detail', $response);
        } catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }
}
