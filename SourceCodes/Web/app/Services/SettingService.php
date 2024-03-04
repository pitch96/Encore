<?php

namespace App\Services;

use App\Models\TransferPayment;
use App\Models\Admin\BannerImage;
use Illuminate\Support\Facades\Crypt;

class SettingService
{
    /**
     * get all banners service.
     */
    public function getAllBanners()
    {
        $collection = BannerImage::orderBy('id', 'desc')->get();
        return $collection->map(function ($banner, $key) {
            $banner->banner_image = asset('/banner-images/'.$banner->banner_image);
            return $banner;
        });
    }

    /**
     * Save Banner data in banner_images tables service
     * @param['description'] longText
     * @param['banner_image'] string
     */
    public function storeBannerImage($request)
    {
        $banner_data = [];
        if (count($request->description) > 0) {
            foreach ($request->description as $key => $description) {
                if (isset($request->banner_image[$key])) {
                    if ($request->hasfile('banner_image')) {
                        $image = time() . '_' . $request->banner_image[$key]->getClientOriginalName();
                        $request->banner_image[$key]->move(public_path('banner-images'), $image);
                        $banner_data[$key] = [
                            'description'   => $description,
                            'banner_image'  => $image
                        ];
                    }
                } else {
                    return [
                        'status'    => 'error',
                        'message'   => trans('messages.banner_image.error.image_required')
                    ];
                }
            }
            BannerImage::insert($banner_data);
            return [
                'status'    => 'success',
                'message'   => trans('messages.banner_image.success.save')
            ];
        } else {
            return [
                'status'    => 'error',
                'message'   => trans('messages.banner_image.error.save')
            ];
        }
    }

    /**
     * get banner by id service.
     * @param['id'] int
     */
    public function getBannerImageById($id)
    {
        $banner_image = BannerImage::findOrFail(Crypt::decrypt($id));
        return $banner_image;
    }

    /**
     * edit Banner data in banner_images tables service.
     * @param['description'] longText
     * @param['banner_image'] string
     */
    public function updateBannerImage($request, $id)
    {
        $banner_image = $this->getBannerImageById($id);
        if ($request->hasFile('banner_image')) {
            $file = $request->file('banner_image');
            $image = time() . '_' . $file->getClientOriginalName();
            $request->banner_image->move(public_path('banner-images'), $image);
        } else {
            $image = $banner_image->banner_image;
        }
        $banner_image = $banner_image->update([
            'description'   => $request->description,
            'banner_image'  => $image
        ]);
        return $banner_image;
    }

    /**
     * Get all transfer Payment service.
    */
    public function getAllTransferedPaymentDetails()
    {
        $paymentTransfers = TransferPayment::orderBy('id', 'desc')->get();
        return $paymentTransfers;
    }
}
