<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Services\UserService;
use App\Services\OrderService;
use Illuminate\Support\Facades\DB;
use App\Services\AddToCartService;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use App\Http\Traits\StripePaymentTrait;
use App\Http\Requests\API\AddToCartFormRequest;
use App\Http\Traits\SuccessAndFailedResponseTrait;

class OrderController extends Controller
{
    use StripePaymentTrait;
    use SuccessAndFailedResponseTrait;
    protected $addToCartService;
    protected $userService;
    protected $orderService;
    public function __construct(AddToCartService $addToCartService, UserService $userService, OrderService $orderService)
    {
        $this->addToCartService = $addToCartService;
        $this->userService = $userService;
        $this->orderService = $orderService;
    }
    /**
     * Add ticket to card
     * @param [Int] user_id
     * @param [Int] ticket_id
     * @param [Int] ticket_qty
     */

     /**
     *  @OA\Post(
     *      path="/api/addToCart",
     *      tags={"Order APIs"},
     *      security={
     *          {"bearerAuth": {}},
     *      },
     *      summary="Add to cart",
     *      operationId="add-to-cart",
     *      @OA\Parameter(
     *          name="user_id",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="ticket_id",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="ticket_qty",
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
    public function addToCart(AddToCartFormRequest $request)
    {
        try {
            $response = $this->addToCartService->addToCartTicket($request);
            if ($response) {
                return $this->successResponse(200, true, trans('messages.cart_added'), $response);
            } else {
                return $this->successResponse(400, true, trans('messages.admin_user.error.not_found'), $response);
            }
        } catch (\Exception $exception) {
            return $this->failedResponse(500, false, $exception->getMessage());
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

    /**
     *  @OA\Post(
     *      path="/api/updateCart",
     *      tags={"Order APIs"},
     *      security={
     *          {"bearerAuth": {}},
     *      },
     *      summary="update to cart",
     *      operationId="update-to-cart",
     *      @OA\Parameter(
     *          name="user_id",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="ticket_id",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="ticket_qty",
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

    public function updateCart(Request $request)
    {
        try {
            $response = $this->addToCartService->updateCartTicket($request);
            if ($response['status'] === 'success') {
                return $this->successResponse(200, true, $response['message'], $response['data']);
            } else {
                return $this->failedResponse(400, false, $response['message']);
            }
        } catch (\Exception $exception) {
            return $this->failedResponse(500, false, $exception->getMessage());
        }
    }

    /**
     * Checkout Function
     */

     /**
     *  @OA\Get(
     *      path="/api/checkout",
     *      tags={"Order APIs"},
     *      security={
     *          {"bearerAuth": {}},
     *      },
     *      summary="Checkout",
     *      operationId="checkout",
     *
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
    public function checkout()
    {
        try {
            $response = $this->addToCartService->checkoutTicket();
            return $this->successResponse(200, true, trans('messages.record_found'), $response);
        } catch (\Exception $exception) {
            return $this->failedResponse(500, false, $exception->getMessage());
        }
    }

    /**
     * delete cart data.
     * @param['id'] int
     */

     /**
     *  @OA\Get(
     *      path="/api/deleteCartItem/{id}",
     *      tags={"Order APIs"},
     *      security={
     *          {"bearerAuth": {}},
     *      },
     *      summary="delete cart item",
     *      operationId="delete_cart_item",
     *
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *
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

    public function deleteCartItem($id)
    {
        try {
            $response = $this->addToCartService->getCartTicket($id);
            if (isset($response)) {
                $response->delete();
                return $this->successResponse(200, true, trans('messages.cart_deleted'), null);
            } else {
                return $this->failedResponse(400, false, trans('messages.cart_not_found'));
            }
        } catch (\Exception $exception) {
            return $this->failedResponse(500, false, trans('messages.cart_not_found'));
        }
    }

    /**
     * referred Event By Promoter
     * @param['event_id'] INT
     * @param['user_id'] INT
     */

     /**
     *  @OA\Get(
     *      path="/api/refferal/event/{event_id}/{user_id}",
     *      tags={"Order APIs"},
     *      security={
     *          {"bearerAuth": {}},
     *      },
     *      summary="Referral Event API",
     *      operationId="referral_event",
     *
     *      @OA\Parameter(
     *          name="event_id",
     *          in="path",
     *          required=true,
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="user_id",
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

    public function referredEvent($event_id, $user_id)
    {
        $userId = Crypt::encrypt($user_id);
        try {
            $response = $this->userService->referredEventByPromoter($event_id, $userId);
            if ($response['status'] === 'error') {
                return $this->failedResponse(400, false, $response['message']);
            }
            return $this->successResponse(200, true, $response['message'], null);
        } catch (\Exception $exception) {
            return $this->failedResponse(400, false, trans('messages.event.error.not_found'));
        }
    }

    /**
     * Placed cart items
     * Save data in orders
     * Save billing address data in billing_address table
     * Update tickets table
     * Update add_to_carts table
     * @param['int'] user_id
     * @param['int'] cart_id
     * @param['array'] billing_address
     */

     /**
     *  @OA\POST(
     *      path="/api/placed/order",
     *      tags={"Order APIs"},
     *      security={
     *          {"bearerAuth": {}},
     *      },
     *      summary="Placed Order",
     *      operationId="placed_order",
     *
     *      @OA\Parameter(
     *          name="user_id",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="cart_items",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="total_price",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="billing_address[active_address_id]",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="billing_address[full_name]",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="billing_address[phone_no]",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="billing_address[email]",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="billing_address[state]",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="billing_address[city]",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="billing_address[zipcode]",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="billing_address[address]",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="stripeToken",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="string"
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

    public function placeOrder(Request $request)
    {
        DB::beginTransaction();
        try {
            Log::channel('stripepaymentlogforbuyer')->info($request->all());
            $response = $this->orderService->orderTickets($request);
            if ($response['status'] === 'error') {
                return $this->failedResponse(400, false, $response['message']);
            } else {
                return $this->successResponse(200, true, $response['message'], null);
            }
        } catch (\Stripe\Exception\CardException $e) {
            $payment_response = $this->failedPaymentResponse($e);
            Log::channel('stripepaymentlogforbuyer')->info($payment_response);
            DB::rollBack();
            return $this->failedResponse(500, false, $e->getError()->message);
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->failedResponse(500, false, $exception->getMessage());
        }
    }

    
    /**
     * Order details after scanning the QR code
     * @param['order_id'] int
     * @param['ticket_no'] int
     */

     /**
     *  @OA\Get(
     *      path="/api/orderDetails/{order_id}/{ticket_no}",
     *      tags={"Order APIs"},
     *      security={
     *          {"bearerAuth": {}},
     *      },
     *      summary="Scanned Order details",
     *      operationId="scanned_order_detail",
     *
     *      @OA\Parameter(
     *          name="order_id",
     *          in="path",
     *          required=true,
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="ticket_no",
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

    public function orderDetails($order_id, $ticket_no)
    {
        try {
            $order_id = base64_encode($order_id);
            $ticket_no = base64_encode($ticket_no);
            $response = $this->orderService->qrDetails($order_id, $ticket_no);
            return $this->successResponse(200, true, trans('messages.record_found'), $response);
        } catch (\Exception $exception) {
            return $this->failedResponse(500, false, $exception->getMessage());
        }
    }

    /**
     *  @OA\Get(
     *      path="/api/qrDetails",
     *      tags={"Order APIs"},
     *      summary="Scanned QR details",
     *      operationId="scanned_qr_detail",
     *
     *      @OA\Parameter(
     *          name="ticket_no",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="string"
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

    public function qrDetails(Request $request)
    {
        try {
            $ticket_no = $request->ticket_no;
            if($request->ticket_no){
                $response = $this->orderService->qrScanDetails($ticket_no);
            }else{
                return $this->failedResponse(400, false, trans('messages.record_not_found'));
            }
            if ($response['status'] === true) {
                return $this->successResponse(200, true, $response['message'], $response['data']);
            } else {
                return $this->failedResponse(400, false, $response['message']);
            }
        } catch (\Exception $exception) {
            return $this->failedResponse(500, false, $exception->getMessage());
        }
    }
}
