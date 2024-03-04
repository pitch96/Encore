<?php

namespace App\Http\Controllers\API\Admin;

use Illuminate\Http\Request;
use App\Services\AdminService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use App\Http\Requests\API\AdminFormRequest;
use App\Http\Traits\SuccessAndFailedResponseTrait;

class ManageUserController extends Controller
{
    use SuccessAndFailedResponseTrait;
    protected $adminService;
    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }

    /**
     * View Manage user page service
     * Get all users from users table
     */

     /**
     *  @OA\Get(
     *      path="/api/admin/manage/users",
     *      tags={"Admin APIs"},
     *      security={
     *          {"bearerAuth": {}},
     *      },
     *      summary="Get All Users",
     *      operationId="all-users",
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

    public function manageUsers(Request $request)
    {
        try {
            $response = $this->adminService->getAllActiveUser();
            if (count($response) > 0) {
                return $this->successResponse(200, true, trans('messages.record_found'), $response);
            } else {
                return $this->successResponse(200, true, trans('messages.record_not_found'), []);
            }
        } catch (\Exception $exception) {
            return $this->failedResponse(500, false, $exception->getMessage());
        }
    }

    /**
     * View Manage Promoter page
     * Get all promoters from users table
     */

     /**
     *  @OA\Get(
     *      path="/api/admin/manage/promoters",
     *      tags={"Admin APIs"},
     *      security={
     *          {"bearerAuth": {}},
     *      },
     *      summary="Get All Promoters",
     *      operationId="all-promoters",
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

    public function managePromoters(Request $request)
    {
        try {
            $response = $this->adminService->getAllActivePromoter();
            if (count($response) > 0) {
                return $this->successResponse(200, true, trans('messages.record_found'), $response);
            } else {
                return $this->successResponse(200, true, trans('messages.record_not_found'), []);
            }
        } catch (\Exception $exception) {
            return $this->failedResponse(500, false, $exception->getMessage());
        }
    }

    public function verifyPromoter($user_id, $status)
    {
        try {
            $response = $this->adminService->changeVerificationStatus($user_id, $status);
            return $this->successResponse(200, true, trans('messages.admin_user.success.update'), $response);
        } catch (\Exception $exception) {
            return $this->failedResponse(500, false, $exception->getMessage());
        }
    }

    /**
     * Edit User Details
     * @param [int] id
     */

     /**
     *  @OA\Get(
     *      path="/api/admin/get/user/{id}",
     *      tags={"Admin APIs"},
     *      security={
     *          {"bearerAuth": {}},
     *      },
     *      summary="Get User/Promoter by Id",
     *      operationId="user/promoter-by-id",
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

    public function getUserById($id)
    {
        try {
            $response = $this->adminService->getUserOrPromoterById(Crypt::encrypt($id));
            if ($response) {
                return $this->successResponse(200, true, trans('messages.record_found'), $response);
            } else {
                return $this->failedResponse(400, false, trans('messages.record_not_found'));
            }
        } catch (\Exception $exception) {
            return $this->failedResponse(400, false, trans('messages.record_not_found'));
        }
    }

    /**
     * Update user details by id
     * @param [string] first_name
     * @param [string] last_name
     * @param [string] user_type
     * @param [string] email
     */

     /**
     *  @OA\Put(
     *      path="/api/admin/update/user/{id}",
     *      tags={"Admin APIs"},
     *      security={
     *          {"bearerAuth": {}},
     *      },
     *      summary="Update User/Promoter by Id",
     *      operationId="update-user/promoter-by-id",
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
     *          in="path",
     *          required=true,
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
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

    public function updateUser(AdminFormRequest $request, $id)
    {
        try {
            $response = $this->adminService->getUserOrPromoterById(Crypt::encrypt($id));
            if ($response) {
                $user = $this->adminService->updateUserPromoter($request, Crypt::encrypt($id));
                return $this->successResponse(200, true, trans('messages.record_updated'), $user);
            } else {
                return $this->failedResponse(400, false, trans('messages.record_not_found'));
            }
        } catch (\Exception $exception) {
            return $this->failedResponse(400, false, trans('messages.record_not_found'));
        }
    }

    /**
     * Delete User Details
     * @param [int] id
     */

     /**
     *  @OA\Delete(
     *      path="/api/admin/delete/user/{id}",
     *      tags={"Admin APIs"},
     *      security={
     *          {"bearerAuth": {}},
     *      },
     *      summary="Delete User/Promoter by Id",
     *      operationId="delete-user/promoter-by-id",
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

    public function deleteUser($id)
    {
        try {
            $response = $this->adminService->getUserOrPromoterById(Crypt::encrypt($id));
            if ($response) {
                $response->delete();
                return $this->successResponse(200, true, trans('messages.record_deleted'), []);
            } else {
                return $this->failedResponse(400, false, trans('messages.record_not_found'));
            }
        } catch (\Exception $exception) {
            return $this->failedResponse(400, false, trans('messages.record_not_found'));
        }
    }
}
