<?php
/**
 * EventService File Doc Comment
 * PHP version 7
 *
 * @category Class
 * @package  Package
 * @author   Encore Events <info@encoreevents.live>
 * @license  URL General
 * @link     https://encoreevents.live/
 */
namespace App\Services;

use Stripe;
use App\Models\User;
use App\Models\Admin\Event;
use App\Models\Admin\Ticket;
use App\Models\Subscription;
use App\Models\Admin\Category;
use App\Models\Admin\BannerImage;
use Illuminate\Support\Facades\Log;
use App\Models\Admin\StripeAccount;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin\PromoterAccess;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Config;
use App\Http\Traits\StripePaymentTrait;
use App\Models\PromotionalEventCharge;

/**
 * Verifies that control statements conform to their coding standards.
 *
 * @category PHP
 * @package  EventService
 * @author   Encore Events <info@encoreevents.live>
 * @license  URL General
 * @version  Release: @package_version@
 * @link     https://encoreevents.live/
 */
class HomePageService
{
    use StripePaymentTrait;
    /**
     * Get All Active Events from events table service
     *
     * @return array
     */
    public function homePageData()
    {
        $event_collection = Event::dashboardEvents()->orderBy('start_date')->limit(9)->get();
        $events = $event_collection->map(function ($event, $key) {
            $event->image = asset('/event-images/'.$event->image);
            return $event;
        });
        $categories = Category::limit(5)->get();
        $banner_collection = BannerImage::where('status', 1)->limit(4)->get();
        $banner_images = $banner_collection->map(function ($banner, $key) {
            $banner->banner_image = asset('/banner-images/'.$banner->banner_image);
            return $banner;
        });
        $popular_event = Event::dashboardEvents()->where('isPopular', 1)->get();
        $takeCount = $popular_event -> count();
        if($takeCount > 4)
        {
            $takeCount = 4;
        }
        $random_popular_event =  Event::dashboardEvents()->where('isPopular', 1)->get()->random($takeCount)->values();
        $popular_events = $popular_event->map(function ($event, $key) {
            $event->image = asset('/event-images/'.$event->image);
            return $event;
        });
        $random_popular_events = $random_popular_event->map(function ($event, $key) {
            $event->image = asset('/event-images/'.$event->image);
            return $event;
        });
        return [
            'events'        => $events,
            'categories'    => $categories,
            'banner_images' => $banner_images,
            'popular_events' => $popular_events,
            'random_popular_events' => $random_popular_events
        ];
    }

    /**
     * Get All Active categories service
     *
     * @return array
     */
    public function getCategories()
    {
        return Category::where('status', 1)->get();
    }

    /**
     * Get All Active banners service
     *
     * @return collection
     */
    public function getBanners()
    {
        $collection = BannerImage::where('status', 1)->limit(4)->get();
        return $collection->map(function ($banner, $key) {
            $banner->banner_image = asset('/banner-images/'.$banner->banner_image);
            return $banner;
        });
    }

    /**
     * Search Events by event_title service
     * @param [string] title
     */
    public function autoCompleteSearch($request)
    {
        $event_collection =  Event::where('status', 1)->allEvents()
            ->where("event_title", "LIKE", "%". $request->title ."%")
            ->get();
        return $event_collection->map(function ($event, $key) {
            $event->image = asset('/event-images/'.$event->image);
            return $event;
        });
    }

    public function getAllBannersImages()
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
        $banner_image = BannerImage::findOrFail($id);
        $banner_image->banner_image = asset('/banner-images/'.$banner_image->banner_image);
        return $banner_image;
    }

    public function getBannerImage($id)
    {
        $banner_image = BannerImage::findOrFail($id);
        return $banner_image;
    }

    /**
     * edit Banner data in banner_images tables service.
     * @param['description'] longText
     * @param['banner_image'] string
     */
    public function updateBannerImage($request, $id)
    {
        $banner_image = $this->getBannerImage($id);
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
     * Search Events service
     * @param [string] title
     * @param [date] date
     * @param [category_id] INT
     */
    public function searchEvent($request)
    {
        $categories = Category::get();
        $events = Event::select("*");
        if (!empty($request->title)) {
            $events->where("event_title", "LIKE", "%". $request->title ."%");
            $events->orwhere("organizer", "LIKE", "%". $request->title ."%");
        }

 
        if ($request->filled('dates')) {
            
            $dates = explode('-', $request->dates);
            $dates = array_map('trim',$dates);

            $events->where("start_date", '>=', date('Y-m-d', strtotime($dates[0])));
            $events->where("start_date", '<=',  date('Y-m-d', strtotime($dates[1])));
        }

        if ($request->filled('category_id')) {
            $events->where("category_id", $request->category_id);
        }
        
        if ($request->filled('zipcode')) {
            $events->where("zipcode", "LIKE", "%". $request->zipcode ."%");
        }

        $event_collection = $events->where('status', 1)->allEvents()->orderBy('start_date')->get();
        $events = $event_collection->map(function ($event, $key) {
            $event->image = asset('/event-images/'.$event->image);
            return $event;
        });
        return [
            'events'        => $events,
            'categories'    => $categories
        ];
    }

    /**
     * Search Events by id service
     */
    public function getEventById($id)
    {
        $stripe_account =  StripeAccount::Where('email', Auth::user()->email)->first();
        $event = Event::with('category')->findOrFail($id);
        $event->image = asset('/event-images/' . $event->image);
        if(strlen(($event->venue_image)) > 0)
        {
            $event->venue_image = asset('/event-images/'.$event->venue_image);
        } 
        
        $promotion_event = PromoterAccess::where(['event_id' => $id, 'promoter_id' => Auth::user()->id, 'payment_status' => 'succeeded'])->first();
        return [
            'stripe_account' => $stripe_account,
            'event' => $event,
            'promotion_event' => $promotion_event,
        ];
    }

    public function getEvent($event_id)
    {
        $tickets = Ticket::where('event_id', $event_id)->activeTicket()->get();
        $event = Event::findOrFail($event_id);
        $event->image = asset('/event-images/'.$event->image);
        if(strlen(($event->venue_image)) > 0)
        {
            $event->venue_image = asset('/event-images/'.$event->venue_image);
        }        

        return [
            'event'     => $event,
            'tickets'   => $tickets
        ];
    }

    /**
     * get tickets by event id service
     * @param['int] id
     */
    public function ticketByEventId($request)
    {
        return Ticket::where('event_id', $request->event_id)->activeTicket()->get();
    }

    /**
     * Search Events by category id service
     * @param['int] id
     */
    public function searchEventsByCategory($category_id)
    {
        if ($category_id != 'all') {
            $event_collection = Event::where("category_id", $category_id)
            ->dashboardEvents()
            ->orderBy('start_date')
            ->limit(9)
            ->get();
        } else {
            $event_collection = Event::dashboardEvents()
                ->orderBy('start_date')
                ->limit(9)
                ->get();
        }
        $events = $event_collection->map(function ($event, $key) {
            $event->image = asset('/event-images/'.$event->image);
            return $event;
        });
        return $events;
    }

    /**
     * Get all subscribed user list page service
     */
    public function subscribedUsers()
    {
        $subscribe_users = Subscription::where('status', 1)->get();
        return $subscribe_users;
    }

    /**
     * handling payment with POST service
     */
    public function promoterPayForEventAccess($request)
    {
        $paybleAmount = PromotionalEventCharge::first()->charge;
        $promoter = Auth::user();
        Stripe\Stripe::setApiKey(config('constants.STRIPE_SECRET'));
        $customer = Stripe\Customer::create(array(
            "email"     =>  $promoter->email,
            "name"      => $promoter->first_name.' '. $promoter->last_name,
            "source"    => $request->stripeToken
        ));
        $charge = Stripe\Charge::create([
            "amount"        => $paybleAmount *100,
            "currency"      => "usd",
            "customer"      =>  $customer->id,
            "description"   => "Test payment from EncoreEvents"
        ]);
        if (!empty($charge)) {
            $payment_response = $this->successPaymentResponse($charge);
            Log::channel('stripepaymentlogforpromoter')->info($payment_response);
            $response = $this->paymentSuccessOrFailed($request, $promoter, $payment_response, $charge);
            return $response;
        } else {
            return [
                'status'    => 'fail',
                'message'   => 'Payment Failed',
            ];
        }
    }

    public function paymentSuccessOrFailed($request, $promoter, $payment_response, $charge)
    {
        $admin_details = User::where('user_type', config('constants.ADMIN_TYPE'))->first();
        $event_details = Event::findOrFail($request->event_id);
        $getData = PromoterAccess::where(['event_id' => $request->event_id, 'promoter_id' => Auth::user()->id, 'payment_status' => 'succeeded' ])->first();
        $data = [
            //Promoter detail
            'name'              => $promoter->first_name.' '. $promoter->last_name,
            'email'             => $promoter->email,
            'phone_no'          => $promoter->phone_no,
            //Admin detail
            'admin_name'        => $admin_details->first_name.' '. $admin_details->last_name,
            'admin_email'       => $admin_details->email,
            'admin_phone_no'    => $admin_details->phone_no,
            //Event detail
            'event_title'       => $event_details->event_title,
            'event_category'    => $event_details->category->name,
            'organizer'         => $event_details->organizer,
            'venue'             => $event_details->venue,
            'address'           => $event_details->address,
            'city'              => $event_details->city,
            'zipcode'           => $event_details->zipcode,
            'start_date'        => $event_details->start_date,
            'end_date'          => $event_details->end_date,
            'start_time'        => $event_details->start_time,
            'end_time'          => $event_details->end_time,
            'description'       => $event_details->description,
        ];
        if (!isset($getData)) {
            $save = PromoterAccess::create([
                'order_no'              => $charge->id,
                'admin_id'              => $admin_details->id,
                'event_id'              => $request->event_id,
                'event_created_by'      => $request->event_created_by,
                'promoter_id'           => Auth::user()->id,
                'date'                  => date('Y-m-d H:i:s'),
                'status'                => 0,
                "amount"                => config('constants.AMOUNT_TO_PROMOTE_EVENT'),
                'currency'              => $charge->currency ?? 'usd',
                'payment_status'        => $charge->status,
                "payment_response"      => json_encode($payment_response),
            ]);
            $promoterTamplate   = 'email.promoter-access-mail';
            $adminTamplate   = 'email.admin-received-request-mail';
            $bodyData   = $data;
            $emailToAdmin    = $data['admin_email'];
            $emailToPromoter    = $data['email'];
            $emailFrom  = Config::get('constants.ADMIN_EMAIL2');
            $adminSubject    = 'Access Request from Promoter';
            $promoterSubject    = 'Access Request to Admin';
            $mailType   = 'Promoter Payment';

            Mail::send($promoterTamplate, $bodyData, function ($message) use ($emailToPromoter, $emailFrom, $promoterSubject, $mailType) {
                $message->from($emailFrom, $mailType);
                $message->to($emailToPromoter);
                $message->subject($promoterSubject);
            });
            Mail::send($adminTamplate, $bodyData, function ($message) use ($emailToAdmin, $emailFrom, $adminSubject, $mailType) {
                $message->from($emailFrom, $mailType);
                $message->to($emailToAdmin);
                $message->subject($adminSubject);
            });
            return [
                'status'    => 'success',
                'message'   => trans('messages.promoter_access.request_sent'),
            ];
        } else {
            return [
                'status'    => 'error',
                'message'   => trans('messages.promoter_access.already_requested'),
            ];
        }
    }
}
