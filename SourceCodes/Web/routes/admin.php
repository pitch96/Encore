<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController\AdminController;
use App\Http\Controllers\AdminController\CategoryController;
use App\Http\Controllers\AdminController\EventController;
use App\Http\Controllers\AdminController\TicketController;
use App\Http\Controllers\AdminController\SettingController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();
Route::group(['middleware' => ['auth'],'prefix' => 'admin'], function () {
    Route::group(['middleware' => ['XssSanitizer']], function () {
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        });

        Route::get('/profile', [AdminController::class, 'profile']);
        Route::get('/purchase', [AdminController::class, 'myPurchases']);
        Route::post('/change/password', [AdminController::class, 'changePassword']);
        Route::put('update/user/{id}', [AdminController::class, 'updateUser']);


        //Manage Category
        Route::group(['middleware' => ['role:1']], function () {
            Route::get('manage/categories', [CategoryController::class, 'manageCategories']);
            Route::get('create/category', [CategoryController::class, 'createCategory']);
            Route::post('save/category', [CategoryController::class, 'saveCategory']);
            Route::get('edit/category/{id}', [CategoryController::class, 'editCategory']);
            Route::put('update/category/{id}', [CategoryController::class, 'updateCategory']);
            Route::get('delete/category/{id}', [CategoryController::class, 'deleteCategory']);
            Route::get('change/category/status/{id}/{status}', [CategoryController::class, 'changeStatus']);
            Route::get('/subscribed/users/list', [AdminController::class, 'subscribedUsers']);
            Route::get('/deleteSubcribedUser/{subcriber_id}', [AdminController::class, 'deleteSubcribedUser']);
            Route::get('manage/users', [AdminController::class, 'manageUsers']);
            Route::get('manage/promoters', [AdminController::class, 'managePromoters']);
            Route::get('verify/promoter/{user_id}/{status}', [AdminController::class, 'verifyPromoter']);
            Route::get('edit/user/{id}', [AdminController::class, 'editUser']);
            Route::get('delete/user/{id}', [AdminController::class, 'deleteUser']);
            Route::get('change/user/status/{id}/{status}', [AdminController::class, 'changeStatus']);
            Route::get('update/charge', [AdminController::class, 'PromotionalEventCharge']);
            Route::put('update/charge/{id}', [AdminController::class, 'updatePromotionalEventCharge']);
        });
        // Start Events Routes
        Route::get('events', [EventController::class, 'events']);
        Route::get('create/event', [EventController::class, 'createEvent']);
        Route::get('manage/events', [EventController::class, 'manageEvents']);
        Route::get('event/details', [EventController::class, 'eventDetailWithOrders']);
        Route::post('save/event', [EventController::class, 'saveEvent']);
        Route::post('event/preview', [EventController::class, 'eventPreview']);
        Route::get('event/detail/{id}', [EventController::class, 'eventDetail']);
        Route::get('edit/event/{id}', [EventController::class, 'editEvent']);
        Route::put('update/event/{id}', [EventController::class, 'updateEvent']);
        Route::get('delete/event/{id}', [EventController::class, 'deleteEvent']);
        Route::post('cancel/event/{id}', [EventController::class, 'cancelEvent']);
        Route::get('cancelled/event/list', [EventController::class, 'cancelledEvent']);
        Route::get('mycancelled/events', [EventController::class, 'myCancelledEvents']);
        Route::get('change/event/status/{id}/{status}', [EventController::class, 'changeStatus']);
        Route::get('change/popular/status/{id}/{status}', [EventController::class, 'changePopularityStatus']);
        Route::get('event/orders/details/{id}', [EventController::class, 'returnOrderDetails']);
        Route::get('refund/promotionalCharge/{id}/{status}', [EventController::class, 'refundPromtionalCharge']);

        Route::post('promoter/access', [EventController::class, 'promoterAccess']);
        Route::get('promotion/list', [EventController::class, 'promotionList']);
        Route::get('promotion/action/{status}/{promotion_event_id}', [EventController::class, 'promotionAction']);
        Route::get('get/access/{event_id}/{creater_id}', [EventController::class, 'getAccess']);
        Route::post('/stripe-payment', [EventController::class, 'handlePost'])->name('stripe.payment');
        // End Events Routes

        // Start Tickets Routes
        Route::get('create/ticket', [TicketController::class, 'createTicket']);
        Route::get('manage/tickets', [TicketController::class, 'manageTickets']);
        Route::post('save/ticket', [TicketController::class, 'saveTicket']);
        Route::get('edit/ticket/{id}', [TicketController::class, 'editTicket']);
        Route::put('update/ticket/{id}', [TicketController::class, 'updateTicket']);
        Route::get('delete/ticket/{id}', [TicketController::class, 'deleteTicket']);
        Route::get('change/ticket/status/{id}/{status}', [TicketController::class, 'changeStatus']);
        // Start Tickets Routes

        // Stripe Payments
        Route::get('stripe/account', [AdminController::class, 'connectStripe']);
        Route::get('transfer/payments', [SettingController::class, 'transferPayments']);
    });

    // Settings
    Route::group(['middleware' => ['role:1']], function () {
        Route::get('banner/images', [SettingController::class, 'index']);
        Route::get('add/banner', [SettingController::class, 'addBanner']);
        Route::post('save/banner', [SettingController::class, 'saveBanner']);
        Route::get('edit/banner/{id}', [SettingController::class, 'editBanner']);
        Route::put('update/banner/{id}', [SettingController::class, 'updateBanner']);
        Route::get('delete/banner/{id}', [SettingController::class, 'deleteBanner']);
        Route::get('change/banner/status/{id}/{status}', [SettingController::class, 'changeBannerStatus']);
    });
    // Route::get('/logout', [AdminController::class,'logout']);
});
