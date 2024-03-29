<?php

use App\Http\Controllers\Api\AboutUsController;
use App\Http\Controllers\Api\PaymentMethodController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ComplaintController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\StateController;
use App\Http\Controllers\Api\TermsPolicyController;
use App\Http\Controllers\Api\UserAuthController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ReviewController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


Route::group(['middleware' => 'SetLanguage'], function () {

    Route::group([
        'prefix' => '/auth',
    ], function () {
        Route::post('/login', [UserAuthController::class, 'login']);
        Route::post('/generate-otp', [UserAuthController::class, 'generateOTP']);
        Route::post('/verify-otp', [UserAuthController::class, 'verifyOTP']);
        Route::post('/register',   [UserAuthController::class, 'register']);
        Route::post('/provider-register', [UserAuthController::class, 'providerRegister']);
        Route::post('/reset-password',    [UserAuthController::class, 'resetPassword']);
        Route::group(['middleware' => 'auth:sanctum'], function () {
            Route::post('/update-profile',  [UserAuthController::class, 'updateProfile']);
            Route::get('/profile-details',  [UserAuthController::class, 'getProfileDetails']);
            Route::post('/logout',          [UserAuthController::class, 'logout']);
            Route::post('/change-password', [UserAuthController::class, 'changePassword']);
            Route::post('/enable-notification', [UserAuthController::class, 'enableNotification']);
        });
    });

    Route::get('/home',    [HomeController::class, 'appHomePage'])->name('app.home');
    Route::get('/config',  [HomeController::class, 'config'])->name('app.config');
    // Route::get('/test',  [HomeController::class, 'containsLocationAtLatLng']);

    Route::group([
        'prefix' => '/users',
        'controller' => UserAuthController::class,
        // 'middleware' => ''
    ], function () {
        Route::get('/providers', 'getAllProviders');
        Route::get('/{id}', 'find')->name('app.user.find');
    });

    Route::group([
        'prefix' => '/states',
        'controller' => StateController::class,
        // 'middleware' => ''
    ], function () {
        Route::get('/', 'getAll');
        Route::get('/{id}', 'find');
    });

    Route::group([
        'prefix' => '/categories',
        'controller' => CategoryController::class,
        // 'middleware' => ''
    ], function () {
        Route::get('/', 'getAll');
        Route::get('/{id}', 'find');
    });

    Route::group([
        'prefix' => '/services',
        'controller' => ServiceController::class,
        // 'middleware' => ''
    ], function () {
        Route::get('/', 'getAll');
        Route::get('/change', 'getAll')->name('app.service.getForProviderChange');
        Route::get('/{id}', 'find')->name('app.service.find');
        Route::post('/change', 'changeProviderServices')->name('app.service.changeProviderServices')->middleware('auth:sanctum');
        Route::post('/add', 'addProviderServices')->name('app.service.addProviderServices')->middleware('auth:sanctum');
        Route::post('/remove', 'removeProviderServices')->name('app.service.removeProviderServices')->middleware('auth:sanctum');
        Route::post('/request', 'orderService')->name('app.service.orderService')->middleware('auth:sanctum');
    });

    Route::group([
        'prefix' => '/payment_methods',
        'controller' => PaymentMethodController::class,
        // 'middleware' => ''
    ], function () {
        Route::get('/', 'getAll');
        Route::get('/{id}', 'find');
        Route::post('/', 'create');
        Route::put('/{id}', 'update');
        Route::delete('/{id}', 'delete');
    });

    Route::group([
        'prefix' => '/orders',
        'controller' => OrderController::class,
        'middleware' => 'auth:sanctum'
    ], function () {
        Route::get('/', 'getAll')->name('app.orders.getAll');
        Route::get('/calendar', 'calendar')->name('app.orders.calendar');
        Route::get('/{id}', 'find');
        Route::post('/', 'create')->name('app.orders.create');
        Route::post('/status/{orderId}', 'status')->name('app.orders.status');
        Route::put('/{id}', 'update');
        Route::delete('/{id}', 'delete');
        Route::post('/cancel-order/{orderId}', 'cancelOrder')->name('app.orders.cancelOrder');
    });

    Route::group([
        'prefix' => '/terms-policies',
        'controller' => TermsPolicyController::class,
        // 'middleware' => ''
    ], function () {
        Route::get('/', 'find');
    });



    Route::group([
        'prefix' => '/complaints',
        'controller' => ComplaintController::class,
        'middleware' => 'auth:sanctum'
    ], function () {
        Route::get('/', 'getAll')->name('app.complaints.get');
        Route::get('/{id}', 'find');
        Route::post('/', 'create');
        Route::post('/reply', 'reply');
    });


    Route::group([
        'prefix' => '/reviews',
        'controller' => ReviewController::class,
        'middleware' => 'auth:sanctum'
    ], function () {
        Route::get('/', 'getAll');
        Route::get('/{id}', 'find');
        Route::post('/', 'create');
        Route::put('/{id}', 'update');
        Route::delete('/{id}', 'delete');
    });

    Route::group([
        'prefix' => '/notifications',
        'controller' => NotificationController::class,
        'middleware' => 'auth:sanctum'
    ], function () {
        Route::get('/', 'userNotification');
        Route::get('/see-all', 'seeAll');
        Route::get('/unseen-count', 'unseenCount');
        Route::delete('/all', 'deleteAll');
        Route::delete('/{id}', 'delete');
    });

    Route::group([
        'prefix' => '/about-us',
        'controller' => AboutUsController::class,
        // 'middleware' => ''
    ], function () {
        Route::get('/', 'find');
    });
});

Route::group([
    'prefix' => '/settings',
    'controller' => SettingController::class,
    // 'middleware' => ''
], function () {
    Route::get('/', 'getAll');
    Route::get('/{id}', 'find');
    Route::post('/', 'create');
    Route::put('/{id}', 'update');
    Route::delete('/{id}', 'delete');
});
