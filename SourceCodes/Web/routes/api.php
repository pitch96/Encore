<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ProfileController;
use App\Http\Controllers\API\PagesController;
use App\Http\Controllers\API\HomeController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\Admin\ManageUserController;
use App\Http\Controllers\API\Admin\CategoryController;
use App\Http\Controllers\API\Admin\EventController;
use App\Http\Controllers\API\Admin\TicketController;
use App\Http\Controllers\API\Admin\SettingController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token, Authorization, Accept,charset,boundary,Content-Length');
header('Access-Control-Allow-Origin: *');

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('aboutus', [PagesController::class, 'aboutUs']);
Route::get('sales', [PagesController::class, 'sales']);
Route::get('termsconditions', [PagesController::class, 'termsConditions']);
Route::get('privacypolicy', [PagesController::class, 'privacyPolicy']);

Route::group(['middleware' => ['XssSanitizer']], function () {
    Route::post('/login', [AuthController::class, 'authenticate']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/forgot/password', [AuthController::class, 'forgotPassword']);
    Route::post('/resend/otp', [AuthController::class, 'resendOtp']);
    Route::post('/reset/password', [AuthController::class, 'resetPassword']);
    Route::get('/account/verify/{token}', [AuthController::class, 'verifyAccount']);
    Route::post('/contactus', [PagesController::class, 'saveContactData']);
    Route::post('/subscribe', [PagesController::class, 'subscribe']);
    Route::get('unsubscribe/{email}', [PagesController::class, 'unsubscribe']);


    Route::get('/categories', [HomeController::class, 'categories']);
    Route::get('/banners', [HomeController::class, 'banners']);
    Route::get('/homepage', [HomeController::class, 'dashboard']);
    Route::get('/search/events', [HomeController::class, 'searchEventByTitle']);
    Route::get('/search/events/{category_id}', [HomeController::class, 'searchEventsByCategory']);
    Route::get('/filter/events', [HomeController::class, 'searchEventsByTitleDateCategory']);
    Route::get('event/details/{id}', [HomeController::class, 'singleEventDetail']);
    Route::get('tickets', [HomeController::class, 'ticketByEventId']);
    
    

    
    Route::group(['middleware' => ['jwt.verify']], function () {
        // Route::group(['middleware' => ['role:1']], function () {
            Route::get('qrDetails', [OrderController::class, 'qrDetails']);
            Route::get('admin/banner/images', [HomeController::class, 'getAllBanners']);
            Route::post('admin/save/banner', [HomeController::class, 'saveBanner']);
            Route::get('admin/edit/banner/{id}', [HomeController::class, 'editBanner']);
            Route::post('admin/update/banner/{id}', [HomeController::class, 'updateBanner']);
            Route::get('admin/delete/banner/{id}', [HomeController::class, 'deleteBanner']);
            Route::get('change/banner/status/{id}/{status}', [HomeController::class, 'changeBannerStatus']);
            Route::get('/subscribed/users/list', [HomeController::class, 'subscribedUsers']);
            Route::post('/pay$1000', [HomeController::class, 'handlePost']);
            Route::get('/admin/update/charge', [HomeController::class, 'promotionalEventCharge']);
            Route::put('/admin/update/charge/{id}', [HomeController::class, 'updatePromotionalEventCharge']);
            // });
            Route::get('event/detail/{id}', [HomeController::class, 'eventDetail']);
            
            Route::get('orderDetails/{order_id}/{ticket_no}', [OrderController::class, 'orderDetails']);
            


        Route::get('/account', [ProfileController::class, 'myAccount']);
        Route::get('/my/order', [ProfileController::class, 'myOrder']);
        Route::get('/billing/address', [ProfileController::class, 'billingAddress']);
        Route::post('/update/profile', [ProfileController::class, 'updateProfile']);
        Route::post('/change/password', [ProfileController::class, 'changePassword']);
        Route::get('/getTicektNo/{order_id}', [ProfileController::class, 'returnTicketNumber']);
        Route::get('/profile', [ProfileController::class, 'profile']);
        Route::get('/myEventOrder', [ProfileController::class, 'myEventOrder']);
        Route::get('/totalPayout', [ProfileController::class, 'promoterTotalPayout']);

        Route::post('/addToCart', [OrderController::class, 'addToCart']);
        Route::post('/updateCart', [OrderController::class, 'updateCart']);
        Route::get('/deleteCartItem/{id}', [OrderController::class, 'deleteCartItem']);
        Route::get('/checkout', [OrderController::class, 'checkout']);
        Route::get('refferal/event/{event_id?}/{user_id?}', [OrderController::class, 'referredEvent']);
        Route::post('/placed/order', [OrderController::class, 'placeOrder']);


        Route::get('admin/manage/users', [ManageUserController::class, 'manageUsers']);
        Route::get('admin/manage/promoters', [ManageUserController::class, 'managePromoters']);
        Route::get('admin/verify/promoter/{user_id}/{status}', [ManageUserController::class, 'verifyPromoter']);
        Route::get('admin/get/user/{id}', [ManageUserController::class, 'getUserById']);
        Route::put('admin/update/user/{id}', [ManageUserController::class, 'updateUser']);
        Route::delete('admin/delete/user/{id}', [ManageUserController::class, 'deleteUser']);
        
        Route::get('admin/categories', [CategoryController::class, 'manageCategories']);
        Route::post('admin/category', [CategoryController::class, 'saveCategory']);
        Route::get('admin/category/{id}', [CategoryController::class, 'editCategory']);
        Route::put('admin/category/{id}', [CategoryController::class, 'updateCategory']);
        Route::delete('admin/category/{id}', [CategoryController::class, 'deleteCategory']);
        Route::get('admin/category/{id}/status/{status}', [CategoryController::class, 'changeStatus']);

        Route::get('admin/promotion/action/{status}/{promotion_event_id}', [EventController::class, 'promotionAction']);
        Route::get('admin/promotion/list', [EventController::class, 'promotionList']);
        Route::get('admin/events', [EventController::class, 'manageEvents']);
        Route::post('admin/event', [EventController::class, 'saveEvent']);
        Route::get('admin/event/{id}', [EventController::class, 'editEvent']);
        Route::put('admin/event/{id}', [EventController::class, 'updateEvent']);
        Route::delete('admin/event/{id}', [EventController::class, 'deleteEvent']);
        Route::get('admin/cancel/event/{event_id}', [EventController::class, 'cancelEvent']);
        Route::get('admin/event/{id}/status/{status}', [EventController::class, 'changeStatus']);
        Route::get('CheckStripeAccount/{id}', [EventController::class, 'CheckStripeAccount']);
        Route::get('myEventDetails', [EventController::class, 'eventDetailWithOrders']);
        Route::get('admin/event/orders/details/{id}', [EventController::class, 'placedEventOrdersDetails']);
        Route::get('admin/change/popular/status/{id}/{status}', [EventController::class, 'changePopularityStatus']);


        // Start Tickets Routes
        Route::get('admin/tickets', [TicketController::class, 'manageTickets']);
        Route::post('admin/ticket', [TicketController::class, 'saveTicket']);
        Route::get('admin/ticket/{id}', [TicketController::class, 'getTicket']);
        Route::put('admin/ticket/{id}', [TicketController::class, 'updateTicket']);
        Route::delete('admin/ticket/{id}', [TicketController::class, 'deleteTicket']);
        Route::get('admin/ticket/{id}/status/{status}', [TicketController::class, 'changeStatus']);
        Route::get('totalTicket/{event_id}', [TicketController::class, 'totalTicekts']);
        
        Route::get('/logout', [AuthController::class, 'logout']);
    });
});
