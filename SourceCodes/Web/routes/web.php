<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController\UserController;
use App\Http\Controllers\UserController\PagesController;
use App\Http\Controllers\UserController\DashboardController;
use App\Http\Controllers\UserController\AddToCartController;
use App\Http\Controllers\UserController\OrderController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\UserVerifyController;
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

Route::group(['middleware' => ['XssSanitizer']], function () {
    Route::get('/login', function () {
        return view('auth.login');
    });
    
    Route::get('/register', function () {
        return view('auth.register');
    });

    // Route::get('/checkout2', function () {
    //     return view('frontend.tc');
    // });

    /**
     * Start Forgot and reset password
     */
    Route::get('forget-password', [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('forget.password.get');
    Route::post('forget-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post');
    Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
    Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');
    /**
     * End Forgot and reset password
     */

    Route::get('account/verify/{token}', [UserVerifyController::class, 'verifyAccount'])->name('user.verify');
    Route::get('/', [DashboardController::class, 'dashboard']);
    Route::get('/old', [DashboardController::class, 'dashboard_old']);
    Route::get('autocomplete', [DashboardController::class, 'autocomplete'])->name('autocomplete');
    Route::any('events', [DashboardController::class, 'events']);
    // Route::any('sales', [DashboardController::class, 'sales']);
    Route::get('event/detail/{id}', [DashboardController::class, 'eventDetail']);
    Route::get('event/details/{id}', [DashboardController::class, 'singleEventDetail']);
    Route::get('refund', [DashboardController::class, 'refund']);

    /**
     * Search events by category id
     */
    Route::get('search/events/{id}', [DashboardController::class, 'searchEventsByCategory']);
    Route::get('filter/events', [DashboardController::class, 'filterEvents']);
    Route::get('aboutus', [PagesController::class, 'aboutUs']);
    Route::get('contactus', [PagesController::class, 'contactUs']);
    Route::post('contactus', [PagesController::class, 'saveContactData']);
    Route::post('contactusajax', [PagesController::class, 'saveContactDataAjax']);
    Route::get('termsconditions', [PagesController::class, 'termsConditions']);
    Route::get('privacypolicy', [PagesController::class, 'privacyPolicy']);
    Route::post('subscribe', [PagesController::class, 'subscribe']);
    Route::get('unsubscribe/{email}', [PagesController::class, 'unsubscribe']);
    Route::get('orderDetails/{order_id}/{ticket_no}', [OrderController::class, 'orderDetails']);
    Route::get('sales', [PagesController::class, 'sales']);


    Auth::routes();

    Route::group(['middleware' => ['auth']], function () {
        Route::get('/account', [UserController::class, 'myAccount'])->middleware(['role:2']);
        Route::get('event/detail/{event_id?}/{user_id?}', [UserController::class, 'referredEvent']);
        Route::post('/AddToCart', [AddToCartController::class, 'addToCart']);
        Route::get('/calculateCart', [AddToCartController::class, 'calculateCart']);
        Route::post('/updateCartData', [AddToCartController::class, 'updateCart']);
        Route::get('/deleteCartItem/{id}', [AddToCartController::class, 'deleteCartItem']);
        Route::get('/checkout', [AddToCartController::class, 'checkout']);
       // Route::get('/checkout2', [AddToCartController::class, 'checkout2']);
        Route::post('/placed/order', [OrderController::class, 'placeOrder']);
        Route::put('/update/user/{id}', [UserController::class, 'updateUser']);
        Route::get('logout', [UserController::class,'logout']);
        Route::post('showQRs/{id}', [UserController::class,'showQrs']);
        Route::get('order/cancellation/details/{id}', [UserController::class,'cancelDetailsForOrders']);
    });
});
