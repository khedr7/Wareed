<?php

use App\Http\Controllers\Api\PaymentMethodController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\StateController;
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
        Route::post('/register', [UserAuthController::class, 'register']);
        Route::post('/reset-password',  [UserAuthController::class, 'resetPassword']);
        Route::group(['middleware' => 'auth:sanctum'], function () {
            Route::post('/update-profile',  [UserAuthController::class, 'updateProfile']);
            Route::get('/profile-details',  [UserAuthController::class, 'getProfileDetails']);
            Route::post('/logout',          [UserAuthController::class, 'logout']);
            Route::post('/change-password', [UserAuthController::class, 'changePassword']);
        });
    });

    Route::get('/home',  [HomeController::class, 'appHomePage'])->name('app.home');

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
        Route::get('/{id}', 'find')->name('app.service.find');
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
        Route::get('/{id}', 'find');
        Route::post('/', 'create')->name('app.orders.create');
        Route::post('/status/{orderId}', 'status')->name('app.orders.status');
        Route::put('/{id}', 'update');
        Route::delete('/{id}', 'delete');
    });

    Route::group([
        'prefix' => '/terms_policies',
        'controller' => TermsPolicyController::class,
        // 'middleware' => ''
    ], function () {
        Route::get('/', 'getAll');
        Route::get('/{id}', 'find');
        Route::post('/', 'create');
        Route::put('/{id}', 'update');
        Route::delete('/{id}', 'delete');
    });

    Route::group([
        'prefix' => '/banners',
        'controller' => BannerController::class,
        // 'middleware' => ''
    ], function () {
        Route::get('/', 'getAll');
        Route::get('/{id}', 'find');
        Route::post('/', 'create');
        Route::put('/{id}', 'update');
        Route::delete('/{id}', 'delete');
    });
});

Route::group([
    'prefix' => '/complaints',
    'controller' => ComplaintController::class,
    // 'middleware' => ''
], function () {
    Route::get('/', 'getAll');
    Route::get('/{id}', 'find');
    Route::post('/', 'create');
    Route::put('/{id}', 'update');
    Route::delete('/{id}', 'delete');
});

Route::group([
    'prefix' => '/complaint_replies',
    'controller' => ComplaintReplyController::class,
    // 'middleware' => ''
], function () {
    Route::get('/', 'getAll');
    Route::get('/{id}', 'find');
    Route::post('/', 'create');
    Route::put('/{id}', 'update');
    Route::delete('/{id}', 'delete');
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
