<?php

use App\Http\Controllers\Api\UserAuthController;
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
Route::group([
    'prefix' => '/auth',
], function () {
    Route::post('/login', [UserAuthController::class, 'login']);
    Route::post('/generate-otp', [UserAuthController::class, 'generateOTP']);
    Route::post('/verify-otp', [UserAuthController::class, 'verifyOTP']);
    Route::post('/register', [UserAuthController::class, 'register']);
    Route::group([], function () {
        Route::post('/reset-password', [UserAuthController::class, 'resetPassword']);
        Route::post('/update-profile', [UserAuthController::class, 'updateProfile']);
        Route::get('/profile-details', [UserAuthController::class, 'getProfileDetails']);
        Route::post('/logout', [UserAuthController::class, 'logout']);
        Route::post('/change-password', [UserAuthController::class, 'changePassword']);
    });
});
Route::group([
    'prefix' => '/users',
    'controller' => UserController::class,
    // 'middleware' => ''
], function () {
    Route::get('/', 'getAll');
    Route::get('/{id}', 'find');
    Route::post('/', 'create');
    Route::put('/{id}', 'update');
    Route::delete('/{id}', 'delete');
});

Route::group([
    'prefix' => '/states',
    'controller' => StateController::class,
    // 'middleware' => ''
], function () {
    Route::get('/', 'getAll');
    Route::get('/{id}', 'find');
    Route::post('/', 'create');
    Route::put('/{id}', 'update');
    Route::delete('/{id}', 'delete');
});

Route::group([
    'prefix' => '/cities',
    'controller' => CityController::class,
    // 'middleware' => ''
], function () {
    Route::get('/', 'getAll');
    Route::get('/{id}', 'find');
    Route::post('/', 'create');
    Route::put('/{id}', 'update');
    Route::delete('/{id}', 'delete');
});

Route::group([
    'prefix' => '/categories',
    'controller' => CategoryController::class,
    // 'middleware' => ''
], function () {
    Route::get('/', 'getAll');
    Route::get('/{id}', 'find');
    Route::post('/', 'create');
    Route::put('/{id}', 'update');
    Route::delete('/{id}', 'delete');
});

Route::group([
    'prefix' => '/services',
    'controller' => ServiceController::class,
    // 'middleware' => ''
], function () {
    Route::get('/', 'getAll');
    Route::get('/{id}', 'find');
    Route::post('/', 'create');
    Route::put('/{id}', 'update');
    Route::delete('/{id}', 'delete');
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
    // 'middleware' => ''
], function () {
    Route::get('/', 'getAll');
    Route::get('/{id}', 'find');
    Route::post('/', 'create');
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
