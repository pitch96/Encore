<?php

namespace App\Http\Controllers\API\Admin;

use Illuminate\Http\Request;
use App\Services\CategoryService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\API\CategoryFormRequest;
use App\Http\Traits\SuccessAndFailedResponseTrait;

class CategoryController extends Controller
{
    use SuccessAndFailedResponseTrait;
    protected $categoryService;
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * View Category page
     * Get the all category from categories table
     */

     /**
     *  @OA\Get(
     *      path="/api/admin/categories",
     *      tags={"Admin APIs"},
     *      security={
     *          {"bearerAuth": {}},
     *      },
     *      summary="Get all Categories",
     *      operationId="all-categories",
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

    public function manageCategories()
    {
        try {
            $response = $this->categoryService->getAllActiveCategory();
            if (count($response) > 0) {
                return $this->successResponse(200, true, trans('messages.record_found'), $response);
            } else {
                return $this->successResponse(200, true, trans('messages.record_not_found'), []);
            }
        } catch (\Exception $exception) {
            return $this->failedResponse(400, false, trans('messages.record_not_found'));
        }
    }

    /**
     * Store category in categories Table
     * @param [int] user_id
     * @param [string] name
     */

     /**
     *  @OA\Post(
     *      path="/api/admin/category",
     *      tags={"Admin APIs"},
     *      security={
     *          {"bearerAuth": {}},
     *      },
     *      summary="Save Category",
     *      operationId="save-category",
     *      @OA\Parameter(
     *          name="name",
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

    public function saveCategory(CategoryFormRequest $request)
    {
        try {
            $response = $this->categoryService->storeCategory($request);
            if (isset($response)) {
                return $this->successResponse(200, true, trans('messages.category.success.save'), $response);
            } else {
                return $this->failedResponse(400, true, trans('messages.category.error.save'));
            }
        } catch (\Exception $exception) {
            return $this->failedResponse(500, false, $exception->getMessage());
        }
    }

    /**
     * Edit category Details
     * @param [int] id
     */

     /**
     *  @OA\Get(
     *      path="/api/admin/category/{category_id}",
     *      tags={"Admin APIs"},
     *      security={
     *          {"bearerAuth": {}},
     *      },
     *      summary="Get Category by Id",
     *      operationId="category-by-id",
     *      @OA\Parameter(
     *          name="category_id",
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

    public function editCategory($id)
    {
        try {
            $response = $this->categoryService->getCategoryById(Crypt::encrypt($id));
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
     * Update category details by id
     * @param [int] user_id
     * @param [string] name
     */

     /**
     *  @OA\Put(
     *      path="/api/admin/category/{category_id}",
     *      tags={"Admin APIs"},
     *      security={
     *          {"bearerAuth": {}},
     *      },
     *      summary="Update Category",
     *      operationId="update-category",
     *      @OA\Parameter(
     *          name="category_id",
     *          in="path",
     *          required=true,
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="name",
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

    public function updateCategory(CategoryFormRequest $request, $id)
    {
        try {
            $response = $this->categoryService->getCategoryById(Crypt::encrypt($id));
            if ($response) {
                $response->update([ 'name' => $request->name ]);
                return $this->successResponse(200, true, trans('messages.record_updated'), $response);
            } else {
                return $this->failedResponse(400, false, trans('messages.record_not_found'));
            }
        } catch (\Exception $exception) {
            return $this->failedResponse(400, false, trans('messages.record_not_found'));
        }
    }

    /**
     * Delete category Details
     * @param [int] id
     */

     /**
     *  @OA\Delete(
     *      path="/api/admin/category/{category_id}",
     *      tags={"Admin APIs"},
     *      security={
     *          {"bearerAuth": {}},
     *      },
     *      summary="Delete Category",
     *      operationId="delete-category",
     *      @OA\Parameter(
     *          name="category_id",
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

    public function deleteCategory($id)
    {
        try {
            $response = $this->categoryService->getCategoryById(Crypt::encrypt($id));
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

    /**
     * Change category Status by id
     * @param [int] id
     */

     /**
     *  @OA\get(
     *      path="/api/admin/category/{id}/status/{status}",
     *      tags={"Admin APIs"},
     *      security={
     *          {"bearerAuth": {}},
     *      },
     *      summary="Change Category Status",
     *      operationId="change-category-status",
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
    public function changeStatus($id, $status)
    {
        try {
            $response = $this->categoryService->getCategoryById(Crypt::encrypt($id));
            if ($response) {
                $response->update(['status' => $status]);
                return $this->successResponse(200, true, trans('messages.category.success.change_status'), []);
            } else {
                return $this->failedResponse(400, false, trans('messages.record_not_found'));
            }
        } catch (\Exception $exception) {
            return $this->failedResponse(400, false, trans('messages.record_not_found'));
        }
    }
}
