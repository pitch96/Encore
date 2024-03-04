<?php

namespace App\Http\Controllers\API;

use App\Services\UserService;
use App\Services\AdminService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Request;
use App\Http\Requests\API\AdminFormRequest;
use App\Http\Traits\SuccessAndFailedResponseTrait;
use App\Http\Requests\API\ChangePasswordFormRequest;

/**
 *For managing the the users profile information
 */
class ProfileController extends Controller
{
    use SuccessAndFailedResponseTrait;
    protected $adminService;
    protected $userService;
    public function __construct(AdminService $adminService, UserService $userService)
    {
        $this->adminService = $adminService;
        $this->userService = $userService;
    }

    /**
     * End User profile function
    */

    /**
     ** @OA\Get(
     *      path="/api/account",
     *      operationId="my_profile",
     *      tags={"My Profile APIs"},
     *      security={
     *          {"bearerAuth": {}},
     *      },
     *      summary="My Profile",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     * @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     * @OA\Response(
     *      response=404,
     *      description="not found"
     *   ),
     *  )
     **/

    public function myAccount()
    {
        try {
            $response = $this->userService->getMyAccountData();
            return $this->successResponse(200, true, trans('messages.record_found'), $response['user']);
        } catch (\Exception $exception) {
            return $this->failedResponse(500, false, $exception->getMessage());
        }
    }

    /**
     * Update Profile function for updating the user profile
     * @param['first_name'] string
     * @param['last_name'] string
     * @param['company_name'] string
     * @param['user_profile'] string
     * @param['phone_no'] string
     */

    /**
     ** @OA\Post(
     *      path="/api/update/profile",
     *      operationId="update_profile",
     *      tags={"My Profile APIs"},
     *      security={
     *          {"bearerAuth": {}},
     *      },
     *      summary="Update Profile",
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
    *          name="first_name",
    *          in="query",
    *          required=true,
    *          @OA\Schema(
    *              type="string"
    *          )
    *      ),
    *      @OA\Parameter(
    *          name="last_name",
    *          in="query",
    *          required=true,
    *          @OA\Schema(
    *              type="string"
    *          )
    *      ),
    *      @OA\Parameter(
    *          name="phone_no",
    *          in="query",
    *          required=false,
    *          @OA\Schema(
    *              type="string"
    *          )
    *      ),
    *      @OA\Parameter(
    *          name="company_name",
    *          in="query",
    *          required=false,
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
    *                       property="user_profile",
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
    public function updateProfile(AdminFormRequest $request)
    {
        try {
            $id = Crypt::encrypt(Auth::user()->id);
            $user = $this->userService->updateUserDetails($request, $id);
            return $this->successResponse(200, true, trans('messages.admin_user.success.update'), $user);
        } catch (\Exception $exception) {
            return $this->failedResponse(500, false, $exception->getMessage());
        }
    }

    /**
     * My Order Details
     */

     /**
     *  @OA\Get(
     *      path="/api/my/order",
     *      tags={"My Profile APIs"},
     *      security={
     *          {"bearerAuth": {}},
     *      },
     *      summary="Get all my order API",
     *      operationId="my_order",
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
    public function myOrder()
    {
        try {
            $collection = $this->userService->getMyOrderData();
            $response = $collection->map(function ($item, $key) {
                $item->order_details = json_decode($item->order_details);
                $item->order_details->event_image =asset('/event-images/'.$item->order_details->event_image);
                return $item;
            });
            return $this->successResponse(200, true, trans('messages.record_found'), $response);
        } catch (\Exception $exception) {
            return $this->failedResponse(500, false, $exception->getMessage());
        }
    }

    /**
     * My Bolling Address
     */

     /**
     *  @OA\Get(
     *      path="/api/billing/address",
     *      tags={"My Profile APIs"},
     *      security={
     *          {"bearerAuth": {}},
     *      },
     *      summary="Get all billing address API",
     *      operationId="billing_address",
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
    public function billingAddress()
    {
        try {
            $response = $this->userService->getBillingAddress();
            return $this->successResponse(200, true, trans('messages.record_found'), $response);
        } catch (\Exception $exception) {
            return $this->failedResponse(500, false, $exception->getMessage());
        }
    }

    /**
     * Change Password function for change the password
     * @param['old_password'] string
     * @param['password'] string
     * @param['password_confirmation'] string
     */

     /**
     *  @OA\Post(
     *      path="/api/change/password",
     *      tags={"My Profile APIs"},
     *      security={
     *          {"bearerAuth": {}},
     *      },
     *      summary="Change password API",
     *      operationId="change_password",
     *      @OA\Parameter(
     *          name="old_password",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="password",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="password_confirmation",
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
    public function changePassword(ChangePasswordFormRequest $request)
    {
        try {
            $response = $this->adminService->changePassword($request);
            if ($response['status'] === 'success') {
                return $this->successResponse(200, true, $response['message'], null);
            } else {
                return $this->failedResponse(400, false, $response['message']);
            }
        } catch (\Exception $exception) {
            return $this->failedResponse(500, false, $exception->getMessage());
        }
    }

     /**
     * Get all ticket_no of specific order
     */

     /**
      * @OA\Get(
      *     path="/api/getTicektNo/{order_id}",
      *     operationId="return_ticket_no",
      *     tags={"Order APIs"},
      *     security={
      *         {"bearerAuth": {}}
      *     },
      *     summary="All tickets for a Order",
      *     @OA\Parameter(
     *          name="order_id",
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     * @OA\Response(
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
      *)
      */
    public function returnTicketNumber($id)
    {
        try{
            $response = $this->userService->QrCodes($id);
            return $this->successResponse(200, true, 'success', $response);
        } catch (\Exception $exception){
            return $this->failedResponse(500, false, $exception->getMessage());
        } 
    }

    /**
     * Get the loggedIn user data
     */

     /**
     *  @OA\Get(
     *      path="/api/profile",
     *      tags={"My Profile APIs"},
     *      security={
     *          {"bearerAuth": {}},
     *      },
     *      summary="Get my profile details API",
     *      operationId="my_profile_details",
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
    public function profile(Request $request)
    {
        try {
            $response = $this->adminService->profileDetail($request);
            return $this->successResponse(200, true, trans('messages.record_found'), $response);
        } catch (\Exception $exception) {
            return back()->withInput()->with('error', $exception->getMessage());
        }
    }

    /*
     *Return the orders for the specific events
     */

     /**
     *  @OA\Get(
     *      path="/api/myEventOrder",
     *      tags={"My Profile APIs"},
     *      security={
     *          {"bearerAuth": {}},
     *      },
     *      summary="Get order for my events API",
     *      operationId="my_events_orders",
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
    public function myEventOrder(Request $request)
    {
        try {
            $response = $this->adminService->orderForMyEvents($request);
            return $this->successResponse(200, true, trans('messages.record_found'), $response);
        } catch (\Exception $exception) {
            return back()->withInput()->with('error', $exception->getMessage());
        }
    }


    /*
     *Calculate the total payout for the promoters API 
     */
    
     /**
     *  @OA\Get(
     *      path="/api/totalPayout",
     *      tags={"My Profile APIs"},
     *      security={
     *          {"bearerAuth": {}},
     *      },
     *      summary="Total Payout API",
     *      operationId="total-payouts",
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
    public function promoterTotalPayout()
    {
        try {
            $response = $this->adminService->totalPayout();
            return $this->successResponse(200, true, trans('messages.record_found'), $response);
        } catch (\Exception $exception) {
            return back()->withInput()->with('error', $exception->getMessage());
        }
    }
}
