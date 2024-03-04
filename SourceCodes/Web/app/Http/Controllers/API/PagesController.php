<?php

namespace App\Http\Controllers\API;

use PSpell\Config;
use Illuminate\Http\Request;
use App\Services\PagesService;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\PagesFormRequest;
use App\Http\Requests\API\SubscribedFormRequest;
use App\Http\Traits\SuccessAndFailedResponseTrait;

class PagesController extends Controller
{
    use SuccessAndFailedResponseTrait;
    protected $pagesService;
    public function __construct(PagesService $pagesService)
    {
        $this->pagesService = $pagesService;
    }

    

    public function saveContactData(PagesFormRequest $request)
    {
        try {
            $response = $this->pagesService->storeContectUs($request);
            return $this->successResponse(200, true, trans('messages.contect_query'), $response);
        } catch (\Exception $exception) {
            return $this->failedResponse(500, false, $exception->getMessage());
        }
    }

   

    public function subscribe(SubscribedFormRequest $request)
    {
        try {
            $this->pagesService->subscribeEvent($request);
            return $this->successResponse(200, true, trans('messages.subscribe_app.subscribed'), null);
        } catch (\Exception $exception) {
            return $this->failedResponse(500, false, trans('messages.subscribe_app.already_subscribed'));
        }
    }

   

    public function unsubscribe($email)
    {
        try {
            $response = $this->pagesService->unSubscribeEvent($email);
            if ($response['status'] === 'success') {
                return $this->successResponse(200, true, $response['message'], null);
            } else {
                return $this->failedResponse(400, false, $response['message']);
            }
        } catch (\Exception $exception) {
            return $this->failedResponse(500, false, $exception->getMessage());
        }
    }

    

    public function aboutUs()
    {
        try {
            $response = $this->pagesService->staticContentData(Config('constants.ABOUT_US'));
            if ($response['status'] === 'success') {
                return $this->successResponse(200, true, $response['message'], $response['data']);
            } else {
                return $this->failedResponse(400, false, $response['message']);
            }
        } catch (\Exception $exception) {
            return $this->failedResponse(500, false, $exception->getMessage());
        }
    }

    public function sales()
    {
        try {
            $response = $this->pagesService->staticContentData(Config('constants.SALES'));
            if ($response['status'] === 'success') {
                return $this->successResponse(200, true, $response['message'], $response['data']);
            } else {
                return $this->failedResponse(400, false, $response['message']);
            }
        } catch (\Exception $exception) {
            return $this->failedResponse(500, false, $exception->getMessage());
        }
    }

   

    public function privacyPolicy()
    {
        try {
            $response = $this->pagesService->staticContentData(Config('constants.PRIVACY_POLICY'));
            if ($response['status'] === 'success') {
                return $this->successResponse(200, true, $response['message'], $response['data']);
            } else {
                return $this->failedResponse(400, false, $response['message']);
            }
        } catch (\Exception $exception) {
            return $this->failedResponse(500, false, $exception->getMessage());
        }
    }

    
    public function termsConditions()
    {
        try {
            $response = $this->pagesService->staticContentData(Config('constants.TERMS_CONDITIONS'));
            if ($response['status'] === 'success') {
                return $this->successResponse(200, true, $response['message'], $response['data']);
            } else {
                return $this->failedResponse(400, false, $response['message']);
            }
        } catch (\Exception $exception) {
            return $this->failedResponse(500, false, $exception->getMessage());
        }
    }
}
