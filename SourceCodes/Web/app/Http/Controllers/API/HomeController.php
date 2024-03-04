<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Services\HomePageService;
use App\Models\Admin\BannerImage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use App\Models\PromotionalEventCharge;
use App\Http\Traits\StripePaymentTrait;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\SettingFormRequest;
use App\Http\Traits\SuccessAndFailedResponseTrait;

class HomeController extends Controller
{
    use SuccessAndFailedResponseTrait;
    use StripePaymentTrait;
    protected $homePageService;
    public function __construct(HomePageService $homePageService)
    {
        $this->homePageService = $homePageService;
    }

    /**
     * Get All Active Events from events table
     */

    /**
     *  @OA\Get(
     *      path="/api/homepage",
     *      tags={"Home Page APIs"},
     *      summary="Home Page API",
     *      operationId="homepage",
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

    public function dashboard()
    {
        try {
            $response = $this->homePageService->homePageData();
            if (count($response) > 0) {
                return $this->successResponse(200, true, trans('messages.record_found'), $response);
            } else {
                return $this->successResponse(200, true, trans('messages.record_not_found'), null);
            }
        } catch (\Exception $exception) {
            return $this->failedResponse(500, false, $exception->getMessage());
        }
    }

    /**
     * Search Events by event_title
     * @param [string] title
     */

     /**
     *  @OA\Get(
     *      path="/api/search/events",
     *      tags={"Home Page APIs"},
     *      summary="Search Events By Title API",
     *      operationId="search_events_by_title",
     *      @OA\Parameter(
     *          name="title",
     *          in="query",
     *          required=false,
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
    public function searchEventByTitle(Request $request)
    {
        try {
            $response = $this->homePageService->autoCompleteSearch($request);
            if (count($response) > 0) {
                return $this->successResponse(200, true, trans('messages.record_found'), $response);
            } else {
                return $this->successResponse(200, true, trans('messages.event.error.not_found'), null);
            }
        } catch (\Exception $exception) {
            return $this->failedResponse(500, false, $exception->getMessage());
        }
    }

    /**
     * Search Events by category id
     * @param['int] id
     */

     /**
     *  @OA\Get(
     *      path="/api/search/events/{category_id}",
     *      tags={"Home Page APIs"},
     *      summary="Search Events By Category Id API",
     *      operationId="search_events_by_category_id",
     *      @OA\Parameter(
     *          name="category_id",
     *          in="path",
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
    public function searchEventsByCategory($category_id)
    {
        try {
            $response = $this->homePageService->searchEventsByCategory($category_id);
            if (count($response) > 0) {
                return $this->successResponse(200, true, trans('messages.record_found'), $response);
            } else {
                return $this->successResponse(200, true, trans('messages.event.error.not_found'), null);
            }
        } catch (\Exception $exception) {
            return $this->failedResponse(500, false, $exception->getMessage());
        }
    }

    /**
     * Search Events by event_title
     * @param [string] title
     * @param [string] date
     * @param [int] category_id
     */

     /**
     *  @OA\Get(
     *      path="/api/filter/events",
     *      tags={"Home Page APIs"},
     *      summary="Search Events By Title Date and Category API",
     *      operationId="search_events_by_title_date_catrgoty_id",
     *
     *      @OA\Parameter(
     *          name="title",
     *          in="query",
     *          required=false,
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="date",
     *          in="query",
     *          required=false,
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="category_id",
     *          in="query",
     *          required=false,
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
    public function searchEventsByTitleDateCategory(Request $request)
    {
        try {
            $response = $this->homePageService->searchEvent($request);
            if (count($response['events']) > 0) {
                return $this->successResponse(200, true, trans('messages.record_found'), $response['events']);
            } else {
                return $this->successResponse(200, true, trans('messages.event.error.not_found'), null);
            }
        } catch (\Exception $exception) {
            return $this->failedResponse(500, false, $exception->getMessage());
        }
    }

    /**
     * Get All active categories
     */

     /**
     *  @OA\Get(
     *      path="/api/categories",
     *      tags={"Home Page APIs"},
     *      summary="Get all categories API",
     *      operationId="categories",
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
    public function categories()
    {
        try {
            $response = $this->homePageService->getCategories();
            if (count($response) > 0) {
                return $this->successResponse(200, true, trans('messages.record_found'), $response);
            } else {
                return $this->successResponse(200, true, trans('messages.category.error.not_found'), null);
            }
        } catch (\Exception $exception) {
            return $this->failedResponse(500, false, $exception->getMessage());
        }
    }

    /**
     * Get All active Banners
     */

     /**
     *  @OA\Get(
     *      path="/api/banners",
     *      tags={"Home Page APIs"},
     *      summary="Get all banners API",
     *      operationId="banners",
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
    public function banners()
    {
        try {
            $response = $this->homePageService->getBanners();
            return $this->successResponse(200, true, trans('messages.record_found'), $response);
        } catch (\Exception $exception) {
            return $this->failedResponse(500, false, $exception->getMessage());
        }
    }

    /**
     * Search Events by id
     */

     /**
     *  @OA\Get(
     *      path="/api/event/details/{event_id}",
     *      tags={"Home Page APIs"},
     *      summary="Get Event detail API",
     *      operationId="event_detail",
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
     **/
    public function singleEventDetail($id)
    {
        try {
            $response = $this->homePageService->getEvent($id);
            return $this->successResponse(200, true, trans('messages.record_found'), $response);
        } catch (\Exception $exception) {
            return $this->failedResponse(500, false, $exception->getMessage());
        }
    }

    /**
     * Search Events Details by id with Stripe Account
     */

     /**
     *  @OA\Get(
     *      path="/api/event/detail/{id}",
     *      tags={"Home Page APIs"},
*           security={
     *          {"bearerAuth": {}},
     *      },
     *      summary="Search Events Details by id with Stripe Account",
     *      operationId="event_details_with_Stripe_Account",
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
    public function eventDetail($id)
    {
        try {
            $response = $this->homePageService->getEventById($id);
            return $this->successResponse(200, true, trans('messages.record_found'), $response);
        } catch (\Exception $exception) {
            return $this->failedResponse(500, false, $exception->getMessage());
        }
    }

    /**
     * Search Events by id
     */

     /**
     *  @OA\Get(
     *      path="/api/tickets",
     *      tags={"Home Page APIs"},
     *      summary="Get tickets by event id API",
     *      operationId="tickets_by_event_id",
     *      @OA\Parameter(
     *          name="event_id",
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
    public function ticketByEventId(Request $request)
    {
        try {
            $response = $this->homePageService->ticketByEventId($request);
            if (count($response) > 0) {
                return $this->successResponse(200, true, trans('messages.record_found'), $response);
            } else {
                return $this->successResponse(200, true, trans('messages.ticket.error.not_found'), null);
            }
        } catch (\Exception $exception) {
            return $this->failedResponse(500, false, trans('messages.ticket.error.not_found'));
        }
    }

    /**
     * Listing of All Banners
     */

     /**
     *  @OA\Get(
     *      path="/api/admin/banner/images",
     *      tags={"Home Page APIs"},
     *      summary="Get Banners API",
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
    public function getAllBanners()
    {
        try {
            $banner_images = $this->homePageService->getAllBannersImages();
            if (count($banner_images) > 0) {
                return $this->successResponse(200, true, trans('messages.record_found'), $banner_images);
            } else {
                return $this->failedResponse(500, false, trans('messages.banner_image.error.not_found'), null);
            }
        } catch (\Exception $exception) {
            return $this->failedResponse(500, false, $exception->getMessage());
        }
    }

    /**
     * Save Banner data in banner_images tables.
     * @param['description'] longText
     * @param['banner_image'] string
     */

     /**
     *  @OA\Post(
     *      path="/api/admin/save/banner",
     *      tags={"Home Page APIs"},
     *      security={
     *          {"bearerAuth": {}},
     *      },
     *      summary="Save Banner API",
     *      operationId="save-banner",
     *      @OA\MediaType(mediaType="multipart/form-data"),
     *      @OA\Parameter(
    *           name="banner_image",
    *           in="query",
    *           @OA\Schema(
    *               type="string",
    *               default="multipart/form-data"
    *           )
    *       ),
     *      @OA\Parameter(
     *          name="description",
     *          in="query",
     *          required=true,
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
    *                       property="image",
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
    public function saveBanner(SettingFormRequest $request)
    {
        $request->validated();
        try {
            $response = $this->homePageService->storeBannerImage($request);
            if ($response['status'] === 'success') {
                return $this->successResponse(200, true, $response['message'], $response);
            } else {
                return $this->failedResponse(500, false, $response['message'], null);
            }
        } catch (\Exception $exception) {
            return $this->failedResponse(500, false, $exception->getMessage());
        }
    }

    /**
     * Get all subscribed user list page
     */

     /**
     *  @OA\Get(
     *      path="/api/subscribed/users/list",
     *      tags={"Home Page APIs"},
     *      security={
     *          {"bearerAuth": {}},
     *      },
     *      summary="Get Subscribed user's list",
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
    public function subscribedUsers()
    {
        try {
            $response = $this->homePageService->subscribedUsers();
            return $this->successResponse(200, true, trans('messages.record_found'), $response);
        } catch (\Exception $exception) {
            return $this->failedResponse(500, false, $exception->getMessage());
        }
    }

    /**
     * Edit Banner form page.
     * @param['id'] int
     */

     /**
     *  @OA\Get(
     *      path="/api/admin/edit/banner/{id}",
     *      tags={"Home Page APIs"},
     *      security={
     *          {"bearerAuth": {}},
     *      },
     *      summary="Edit Banner API",
     *      operationId="edit_banner_by_id",
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
    public function editBanner($id)
    {
        try {
            $banner_image = $this->homePageService->getBannerImage($id);
            return $this->successResponse(200, true, trans('messages.record_found'), $banner_image);
        } catch (\Exception $exception) {
            return $this->failedResponse(500, false, trans('messages.record_not_found'));
        }
    }
    
     /**
     *  @OA\Post(
     *      path="/api/pay$1000",
     *      tags={"Home Page APIs"},
     *      security={
     *          {"bearerAuth": {}},
     *      },
     *      summary="Pay $1000",
     *      operationId="Pay $1000 for access",
     *      @OA\Parameter(
    *           name="event_id",
    *           in="header",
    *           @OA\Schema(
    *               type="integer",
    *           )
    *       ),
     *      @OA\Parameter(
     *          name="event_created_by",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="integer"
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
    public function handlePost(Request $request)
    {
        try {      
            $paybleAmount = PromotionalEventCharge::first()->charge;
            Log::channel('stripepaymentlogforpromoter')->info($request->all());
            if ($paybleAmount > (float)str_replace('$', '', $request->payable_amount)) {
                return $this->failedResponse(500, false, trans('messages.insufficient_amount') . $paybleAmount); 
            }
            if ($paybleAmount < (float)str_replace('$', '', $request->payable_amount)) {
                return $this->failedResponse(500, false, trans('messages.extra_amount') . $paybleAmount);
            }
            $response = $this->homePageService->promoterPayForEventAccess($request);
            switch ($response['status']) {
                case "success":
                    return $this->successResponse(200, true, $response['message'], $response);
                case "error":
                    return $this->failedResponse(500, false, $response['message']);
                case "fail":
                    return $this->failedResponse(500, false, $response['message']);
                default:
                    // return Redirect::to('admin/event/detail/'.Crypt::encrypt($request->event_id));
            }
        } catch (\Stripe\Exception\CardException $e) {
            $payment_response = $this->failedPaymentResponse($e);
            Log::channel('stripepaymentlogforpromoter')->info($payment_response);
            return $this->failedResponse(500, false, $e->getMessage());
        } catch (\Exception $e) {
            return $this->failedResponse(500, false, $e->getMessage());
        }
    }

    /**
     * Update Banner data in banner_images tables.
     * @param['description'] longText
     * @param['banner_image'] string
     */

     /**
     *  @OA\Post(
     *      path="/api/admin/update/banner/{id}",
     *      tags={"Home Page APIs"},
     *      security={
     *          {"bearerAuth": {}},
     *      },
     *      summary="Update Banner API",
     *      operationId="update-banner",
     *      @OA\MediaType(mediaType="multipart/form-data"),
     *      @OA\Parameter(
    *           name="id",
    *           in="path",
    *           required=true,
    *           @OA\Schema(
    *               type="integer",
    *               default="multipart/form-data"
    *           )
    *       ),
     *      @OA\Parameter(
    *           name="banner_image",
    *           in="query",
    *           required=true,
    *           @OA\Schema(
    *               type="string",
    *               default="multipart/form-data"
    *           )
    *       ),
     *      @OA\Parameter(
     *          name="description",
     *          in="query",
     *          required=true,
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
    *                       property="image",
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
    public function updateBanner(SettingFormRequest $request, $id)
    {
        $request->validated();
        try {
            $this->homePageService->updateBannerImage($request, $id);
            return $this->successResponse(200, true, trans('messages.banner_image.success.update'), null);
        } catch (\Exception $exception) {
            return $this->failedResponse(500, false, $exception->getMessage());
        }
    }

    /**
     * delete Banner data from banner_images tables using banner id.
     * @param['id'] int
     */

     /**
     *  @OA\Get(
     *      path="/api/admin/delete/banner/{id}",
     *      tags={"Home Page APIs"},
     *      security={
     *          {"bearerAuth": {}},
     *      },
     *      summary="Delete Banner API",
     *      operationId="delete_banner",
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
    public function deleteBanner($id)
    {
        try {
            $this->homePageService->getBannerImage($id)->delete();
            return $this->successResponse(200, true, trans('messages.banner_image.success.delete'), null);
        } catch (\Exception $exception) {
            return $this->failedResponse(500, false, $exception->getMessage());
        }
    }

    /**
     * Change Banner status using banner id.
     * @param['id'] int
     * change/banner/status/{id}/{status}
     */

     /**
     *  @OA\get(
     *      path="/api/change/banner/status/{id}/{status}",
     *      tags={"Home Page APIs"},
     *      security={
     *          {"bearerAuth": {}},
     *      },
     *      summary="Change Banner Status",
     *      operationId="change-banner-status",
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
    public function changeBannerStatus($id, $status)
    {
        try {
            $banner = $this->homePageService->getBannerImage($id);
            $banner->update(['status' => $status]);
            return $this->successResponse(200, true, trans('messages.banner_image.success.change_status'), null);
        } catch (\Exception $exception) {
            return $this->failedResponse(500, false, $exception->getMessage());
        }
    }

    /**
     * Update the Promotional event charge
     */
    public function promotionalEventCharge(Request $request)
    {
        try {
            $response = PromotionalEventCharge::first();
            if ($response) {
                return $this->successResponse(200, true, trans('messages.record_found'), $response);
            } else {
                return $this->failedResponse(400, false, trans('messages.record_not_found'));
            }
        } catch (\Exception $exception) {
            return $this->failedResponse(500, false, $exception->getMessage());
        }
    }

    /**
     * function to update the promotional event charge
     */
    public function updatePromotionalEventCharge(Request $request, $id)
    {
        try {
            $request->validate([
                'charge' => 'required|min: >0',
            ]);
            $response = PromotionalEventCharge::findOrFail($id);
            if ($response) {
                $response->update([
                    'charge' => $request->charge
                ]);
                return $this->successResponse(200, true, trans('messages.record_updated'), $response);
            } else {
                return $this->failedResponse(400, false, trans('messages.record_not_found'));
            }
        } catch (\Exception $exception) {
            return $this->failedResponse(500, false, $exception->getMessage());
        }
    }
}
