<?php

namespace App\Http\Controllers\UserController;

use App\Models\TicketOrder;
use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\AdminFormRequest;
use App\Models\Admin\Order;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    protected $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    /**
     * logout function
     */
    public function logout(Request $request)
    {
        try {
            $request->session()->forget('intendedUrl');
            if (Auth::user()->user_type === config('constants.ADMIN_TYPE') || Auth::user()->user_type === config('constants.PROMOTER_TYPE')) {
                Auth::logout();
                return Redirect::to('/login');
            } else {
                Auth::logout();
                return Redirect::to('/');
            }
        } catch (\Exception $exception) {
            return Redirect::back()->with('error', $exception->getMessage());
        }
    }

    /**
     * End User profile function
     */
    public function myAccount()
    {
        try {
            $response = $this->userService->getMyAccountData();
            return view('frontend.profile', $response);
        } catch (\Exception $exception) {
            return Redirect::back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Update user details by id
     * @param [string] first_name
     * @param [string] last_name
     * @param [string] email
     */
    public function updateUser(AdminFormRequest $request, $id)
    {
        $request->validated();
        try {
            $this->userService->updateUserDetails($request, $id);
            return Redirect::back()->with('success', trans('messages.admin_user.success.update'));
        } catch (\Exception $exception) {
            return Redirect::back()->with('error', $exception->getMessage());
        }
    }

    /**
     * referred Event By Promoter
     * @param['event_id'] INT
     * @param['user_id'] INT
     */
    public function referredEvent($event_id, $user_id)
    {
        try {
            $response = $this->userService->referredEventByPromoter($event_id, $user_id);
            if ($response['status'] === 'error') {
                return Redirect::to('/event/detail/'.$event_id)->with('error', $response['message']);
            }
            return view('frontend.event-detail', $response);
        } catch (\Exception $exception) {
            return Redirect::back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Show the Qr Code for orders
     */
    public function showQRs(Request $request,$id)
    {
        try{
            $response = $this->userService->QrCodesWeb($request, $id);
            return response()->json($response);
        } catch (\Exception $exception){
            return Redirect::back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Return refund details for the cancelled orders
     */
    public function cancelDetailsForOrders($id)
    {
        try{
            $response = $this->userService->findOrderDetails($id);
            return response()->json($response);
        } catch (\Exception $exception){
            return Redirect::back()->with('error', $exception->getMessage());
        }
    }

    public function table(){
        return view('table');
    }
}
