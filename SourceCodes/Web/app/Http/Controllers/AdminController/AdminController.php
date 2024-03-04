<?php

namespace App\Http\Controllers\AdminController;

use Illuminate\Http\Request;
use App\Services\AdminService;
use PhpParser\Node\Stmt\TryCatch;
use Illuminate\Support\Facades\DB;
use App\Models\Admin\StripeAccount;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\PromotionalEventCharge;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\AdminFormRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Crypt;
use App\Http\Requests\ChangePasswordFormRequest;
use App\Http\Requests\UpdateChargeRequest;

class AdminController extends Controller
{
    protected $adminService;
    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }

    /**
     * View Admin profile page
     * Get the loggedIn user data
     */
    public function profile(Request $request)
    {
        try {
            $response = $this->adminService->profileDetail($request);
            return view('admin.profile', $response);
        } catch (\Exception $exception) {
            return back()->withInput()->with('error', $exception->getMessage());
        }
    }

    public function myPurchases(){
        try {
            $response = $this->adminService->myPurchase();
            return view('admin.myPurchases', $response);
        } catch (\Exception $exception) {
            return back()->withInput()->with('error', $exception->getMessage());
        }
    }

    /**
     * logout function
     */
    public function logout(Request $request)
    {
        try {
            Auth::logout();
            $request->session()->forget('intendedUrl');
            return Redirect::to('login');
        } catch (\Exception $exception) {
            return back()->withInput()->with('error', $exception->getMessage());
        }
    }

    /**
     * View Manage user page service
     * Get all users from users table
     */
    public function manageUsers(Request $request)
    {
        try {
            $users = $this->adminService->getAllActiveUser();
            return view('admin.users', compact('users'));
        } catch (\Exception $exception) {
            return back()->withInput()->with('error', $exception->getMessage());
        }
    }

    /**
     * View Manage Promoter page
     * Get all promoters from users table
     */
    public function managePromoters(Request $request)
    {
        try {
            $users = $this->adminService->getAllActivePromoter();
            return view('admin.promoters', compact('users'));
        } catch (\Exception $exception) {
            return back()->withInput()->with('error', $exception->getMessage());
        }
    }

    public function verifyPromoter($user_id, $status)
    {
        try {
            $userID = Crypt::decrypt($user_id);
            $response = $this->adminService->changeVerificationStatus($userID, $status);
            return response()->json($response);
        } catch (\Exception $exception) {
            return back()->withInput()->with('error', $exception->getMessage());
        }
    }

    /**
     * Edit User Details
     * @param [int] id
     */
    public function editUser($id)
    {
        try {
            $user = $this->adminService->getUserOrPromoterById($id);
            return view('admin.edit-user', compact('user'));
        } catch (\Exception $exception) {
            return Redirect::to("/admin/manage/users")->with('error', $exception->getMessage());
        }
    }

    /**
     * Update user details by id
     * @param [string] first_name
     * @param [string] last_name
     * @param [string] user_type
     * @param [string] email
     */
    public function updateUser(AdminFormRequest $request, $id)
    {
        $request->validated();
        try {
            $user = $this->adminService->updateUserPromoter($request, $id);
            if (url()->previous() === url('/').'/admin/profile') {
                return back()->withInput()->with('success', trans('messages.admin_user.success.update'));
            }
            if ($user->user_type === config('constants.USER_TYPE')) {
                return Redirect::to('/admin/manage/users')->with('success', trans('messages.admin_user.success.update'));
            } elseif ($user->user_type === config('constants.PROMOTER_TYPE')) {
                return Redirect::to('/admin/manage/promoters')->with('success', trans('messages.promoter_user.success.update'));
            }
        } catch (\Exception $exception) {
            return back()->withInput()->with('error', $exception->getMessage());
        }
    }

    /**
     * change user password service
     * @param [string] old_password
     * @param [string] new_password
     * @param [string] confirm_password
     */
    public function changePassword(ChangePasswordFormRequest $request)
    {
        $request->validated();
        try {
            $response = $this->adminService->changePassword($request);
            if ($response['status'] === 'success') {
                return Redirect::back()->with("success", $response['message']);
            } else {
                return Redirect::back()->with("error", $response['message']);
            }
        } catch (\Exception $exception) {
            return Redirect::back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Delete User Details
     * @param [int] id
     */
    public function deleteUser($id)
    {
        try {
            $user = $this->adminService->getUserOrPromoterById($id);
            if ($user->user_type === config('constants.USER_TYPE')) {
                $user->delete();
                return response()->json([
                    'status' => true,
                    'message' => trans('messages.admin_user.success.delete')
                ]);
            } elseif ($user->user_type === config('constants.PROMOTER_TYPE')) {
                $user->delete();
                return response()->json([
                    'status' => true,
                    'message' => trans('messages.promoter_user.success.delete')
                ]);
            }
        } catch (\Exception $exception) {
            return response()->json([
                'status' => false,
                'message' => $exception->getMessage()
            ]);
        }
    }

    /**
     * Change User Status by id
     * @param [int] id
     */
    public function changeStatus($id, $status)
    {
        try {
            $user = $this->adminService->getUserOrPromoterById($id);
            if ($user->user_type === config('constants.USER_TYPE')) {
                $user->update(['status' => $status]);
                return Redirect::to("/admin/manage/users")->with('success', trans('messages.admin_user.success.change_status'));
            } elseif ($user->user_type === config('constants.PROMOTER_TYPE')) {
                $user->update(['status' => $status]);
                return Redirect::to('/admin/manage/promoters')->with('success', trans('messages.promoter_user.success.change_status'));
            }
        } catch (\Exception $exception) {
            return Redirect::back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Get all subscribed user list page
     */
    public function subscribedUsers()
    {
        try {
            $subscribe_users = $this->adminService->subscribedUsers();
            return view('admin.subscribed-users', compact('subscribe_users'));
        } catch (\Exception $exception) {
            return Redirect::back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Delete subscribed user according to ID 
     */
    public function deleteSubcribedUser($id)
    {
        try {
            $this->adminService->deleteSubscribedUsers($id);
            return response()->json([
                'status' => true,
                'message' => trans('messages.record_deleted')
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'status' => false,
                'message' => $exception->getMessage()
            ]);
        }
    }

    /**
     * Connect promoter to stripe
     */
    public function connectStripe()
    {
        try {
            $response = $this->adminService->connectPromoterWithStripe();
            if ($response['status'] === 'success') {
                return Redirect::to($response['url']);
            } else {
                return Redirect::back()->with("error", trans('messages.connect_with_stripe_error'));
            }
        } catch (\Exception $exception) {
            return Redirect::back()->with('error', $exception->getMessage());
        }
    }


    /**
     * Update the Promotional event charge
     */
    public function PromotionalEventCharge(){
        try {
            $response = PromotionalEventCharge::first();
            if ($response) {
                return view('admin.promotional-charge', compact('response'));
            } else {
                return view('admin.promotional-charge');
            }
        } catch (\Exception $exception) {
            return Redirect::back()->with('error', $exception->getMessage());
        }
    }

    public function updatePromotionalEventCharge(UpdateChargeRequest $request, $id)
    {
        $request->validated();
        try {
            $response = PromotionalEventCharge::findOrFail(Crypt::decrypt($id));
            if ($response) {
                $response->update(['charge' => $request->charge]);
                return Redirect::to("/admin/update/charge")->with('success', trans('Price updated Successfully'));
            } else {
                return Redirect::to("/admin/update/charge")->with('error', trans('Price not set'));
            }
        } catch (\Exception $exception) {
            return Redirect::back()->with('error', $exception->getMessage());
        }
    }
}
