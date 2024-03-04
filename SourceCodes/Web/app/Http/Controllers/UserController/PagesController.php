<?php

namespace App\Http\Controllers\UserController;

use App\Rules\Recaptcha;
use Illuminate\Http\Request;
use App\Services\PagesService;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\PagesFormRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class PagesController extends Controller
{
    protected $pagesService;
    public function __construct(PagesService $pagesService)
    {
        $this->pagesService = $pagesService;
    }

    /**
     * Function for showing the about us content
     */
    public function aboutUs()
    {
        return view("frontend.aboutus");
    }

    /**
     * Function for showing the contact Us content
     */
    public function contactUs()
    {
        Log::info("this is todays contact message");
        return view("frontend.contact_us");
    }

    /**
     * Function for showing market with us page
     */
    public function sales()
    {
        Log::info("this is the sales");
        return view("frontend.sales");
    }

    /**
     * Save contact Us data in contactus table
     * @param['string']name
     * @param['string']email
     * @param['string']phone_no
     * @param['string']queries
     */
    public function saveContactData(PagesFormRequest $request)
    {
        $request->validated();
        try {
            $this->pagesService->storeContectUs($request);
            return Redirect::back()->withSuccess(trans('messages.contect_query'));
        } catch (\Exception $exception) {
            return Redirect::back()->withInput()->withError($exception->getMessage());
        }
    }

        /**
     * Save contact Us data in contactus table
     * @param['string']name
     * @param['string']email
     * @param['string']phone_no
     * @param['string']queries
     */
    public function saveContactDataAjax(PagesFormRequest $request)
    {
        $request->validated();
        try {
            $this->pagesService->storeContectUs($request);
            return response()->json(['status'=>'success', 'message'=>trans('messages.contect_query')]);
        } catch (\Exception $exception) {
            return response()->json(['status'=>'error', 'message'=>trans('messages.admin_user.error.save')]);
        }
    }

    /**
     * Terms and conditions page
     */
    public function termsConditions()
    {
        return view("frontend.terms&conditions");
    }

    /**
     * Privacy policy page
     */
    public function privacyPolicy()
    {
        return view("frontend.privacy&policy");
    }

    /**
     * Save subscription data in subscriptions table
     * @param['string']email
     */
    public function subscribe(Request $request)
    {
        Log::info('Subscribed for user email: ' . $request->email);
        try {
            $validate = Validator::make($request->all(), [
                'email' => 'required|string|email|unique:subscriptions',
                'g-recaptcha-response' => 'required',
            ]);
            if ($validate->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $validate->errors()->all()
                ]);
            } else {
                $this->pagesService->subscribeEvent($request);
                return response()->json([
                    'status'    => 'success',
                    'message'   => trans('messages.subscribe_app.subscribed')
                ]);
            }
        } catch (\Exception $exception) {
            return response()->json([
                'status'    => 'error',
                'message'   => trans('messages.subscribe_app.already_subscribed')
            ]);
        }
    }

    /**
     * Unsubscription data in subscriptions table
     * @param['string']email
     */
    public function unsubscribe($email)
    {
        try {
            $this->pagesService->unSubscribeEvent($email);
            return Redirect::to('/')->withSuccess(trans('messages.unsubscribe'));
        } catch (\Exception $exception) {
            return Redirect::to('/')->withError($exception->getMessage());
        }
    }
}
