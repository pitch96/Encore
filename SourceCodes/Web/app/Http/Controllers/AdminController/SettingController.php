<?php

namespace App\Http\Controllers\AdminController;

use Illuminate\Http\Request;
use App\Services\SettingService;
use App\Models\Admin\BannerImage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\SettingFormRequest;

class SettingController extends Controller
{
    protected $settingService;
    public function __construct(SettingService $settingService)
    {
        $this->settingService = $settingService;
    }
    /**
     * Display a listing of all banner.
     */
    public function index()
    {
        $banner_images = $this->settingService->getAllBanners();
        return view('admin.settings.index', compact('banner_images'));
    }

    /**
     * Display add banner form page.
     */
    public function addBanner(Request $request)
    {
        return view('admin.settings.add-banner');
    }

    /**
     * Save Banner data in banner_images tables.
     * @param['description'] longText
     * @param['banner_image'] string
     */
    public function saveBanner(SettingFormRequest $request)
    {
        $request->validated();
        try {
            $response = $this->settingService->storeBannerImage($request);
            if ($response['status'] === 'success') {
                return Redirect::to('admin/banner/images')->withSuccess($response['message']);
            } else {
                return back()->withInput()->with('error', $response['message']);
            }
        } catch (\Exception $exception) {
            return Redirect::back()->withInput()->withError($exception->getMessage());
        }
    }

    /**
     * Edit Banner form page.
     * @param['id'] int
     */
    public function editBanner($id)
    {
        try {
            $banner_image = $this->settingService->getBannerImageById($id);
            return view('admin.settings.edit-banner', compact('banner_image'));
        } catch (\Exception $exception) {
            return Redirect::back()->with('error', $exception->getMessage());
        }
    }

    /**
     * edit Banner data in banner_images tables.
     * @param['description'] longText
     * @param['banner_image'] string
     */
    public function updateBanner(SettingFormRequest $request, $id)
    {
        $request->validated();
        try {
            $this->settingService->updateBannerImage($request, $id);
            return Redirect::to('admin/banner/images')->withSuccess(trans('messages.banner_image.success.update'));
        } catch (\Exception $exception) {
            return Redirect::back()->withError($exception->getMessage());
        }
    }

    /**
     * delete Banner data from banner_images tables using banner id.
     * @param['id'] int
     */
    public function deleteBanner($id)
    {
        try {
            $this->settingService->getBannerImageById($id)->delete();
            return response()->json([
                'status'    => true,
                'message'   => trans('messages.banner_image.success.delete')
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'status'    => false,
                'message'   => $exception->getMessage()
            ]);
        }
    }

    /**
     * Change Banner status using banner id.
     * @param['id'] int
     */
    public function changeBannerStatus($id, $status)
    {
        try {
            $banner = $this->settingService->getBannerImageById($id);
            $banner->update(['status' => $status]);
            return response()->json([
                'status'    => true,
                'message'   => trans('messages.banner_image.success.change_status')
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'status'    => false,
                'message'   => $exception->getMessage()
            ]);
        }
    }

    /**
     * Get all transfer Payment.
    */
    public function transferPayments()
    {
        try {
            $paymentTransfers = $this->settingService->getAllTransferedPaymentDetails();
            return view('admin.transfer-payment', compact('paymentTransfers'));
        } catch (\Exception $exception) {
            return Redirect::back()->with('error', $exception->getMessage());
        }
    }
}
