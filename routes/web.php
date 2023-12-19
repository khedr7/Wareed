<?php

use App\Http\Controllers\BannerController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\ComplaintReplyController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ServiceRequestController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\TermsPolicyController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('auth');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('auth');

Auth::routes();

// Route::get('/home', function () {
//     return view('home');
// })->name('home')->middleware('auth');


Route::group(['middleware' => 'auth'], function () {
    Route::resource('user', UserController::class);

    Route::group(['prefix' => 'users'], function () {
        Route::get('/', [UserController::class, 'index'])->name('users.admin.index');
        Route::get('/providers', [UserController::class, 'indexProviders'])->name('users.admin.providers');
        Route::get('/reviews', [UserController::class, 'providersReviews'])->name('users.admin.providersReviews');
        Route::get('/reviews/all', [UserController::class, 'allReviews'])->name('users.admin.allReviews');
        Route::get('/reviews/{userId}', [UserController::class, 'providerReviews'])->name('users.admin.providerReviews');
        Route::get('/providers-requests', [UserController::class, 'providersRequests'])->name('users.admin.providersRequests');
        Route::get('/create',        [UserController::class, 'create'])->name('users.admin.create');
        Route::post('/bulk-delete',  [UserController::class, 'bulkDelete'])->name('users.admin.bulkDelete');
        Route::post('/reviews/bulk-delete',  [UserController::class, 'reviewsBulkDelete'])->name('users.admin.reviewsBulkDelete');
        Route::post('/',        [UserController::class, 'store'])->name('users.admin.store');
        Route::get('/{userId}', [UserController::class, 'show'])->name('users.admin.show');
        Route::get('/{userId}/edit',  [UserController::class, 'edit'])->name('users.admin.edit');
        Route::post('/add-points/{userId}',   [UserController::class, 'addPoints'])->name('users.admin.addPoints');
        Route::post('/{userId}',      [UserController::class, 'update'])->name('users.admin.update');
        Route::get('/status/{userId}',   [UserController::class, 'status'])->name('users.admin.status');
        Route::get('/accept/{userId}',   [UserController::class, 'accept'])->name('users.admin.accept');
        Route::get('/reviews/approved/{reviewId}', [UserController::class, 'reviewApprove'])->name('users.admin.reviewApprove');
        Route::delete('/{userId}',          [UserController::class, 'delete'])->name('users.admin.delete');
        Route::delete('reviews/{reviewId}', [UserController::class, 'deleteReviews'])->name('users.admin.deleteReviews');
    });

    Route::group(['prefix' => 'states'], function () {
        Route::get('/', [StateController::class, 'index'])->name('states.admin.index');
        Route::get('/{stateId}/cities', [StateController::class, 'getCities'])->name('states.admin.cities');
        Route::get('/cities-dropdown/{stateId}', [StateController::class, 'dropdownCities'])->name('states.admin.dropdownCities');
        Route::get('/create',   [StateController::class, 'create'])->name('states.admin.create');
        Route::post('/',        [StateController::class, 'store'])->name('states.admin.store');
        Route::get('/{stateId}', [StateController::class, 'show'])->name('states.admin.show');
        Route::get('/{stateId}/edit',  [StateController::class, 'edit'])->name('states.admin.edit');
        Route::post('/{stateId}',      [StateController::class, 'update'])->name('states.admin.update');
        Route::delete('/{stateId}',    [StateController::class, 'delete'])->name('states.admin.delete');
    });

    Route::group(['prefix' => 'cities'], function () {
        Route::get('/', [CityController::class, 'index'])->name('cities.admin.index');
        Route::get('/{stateId}/create',  [CityController::class, 'create'])->name('cities.admin.create');
        Route::post('/bulk-delete',      [CityController::class, 'bulkDelete'])->name('cities.admin.bulkDelete');
        Route::post('/',        [CityController::class, 'store'])->name('cities.admin.store');
        Route::get('/{cityId}', [CityController::class, 'show'])->name('cities.admin.show');
        Route::get('/{cityId}/edit',  [CityController::class, 'edit'])->name('cities.admin.edit');
        Route::post('/{cityId}',      [CityController::class, 'update'])->name('cities.admin.update');
        Route::get('/status/{cityId}',  [CityController::class, 'status'])->name('cities.admin.status');
        Route::delete('/{cityId}',      [CityController::class, 'delete'])->name('cities.admin.delete');
    });

    Route::group(['prefix' => 'categories'], function () {
        Route::get('/', [CategoryController::class, 'index'])->name('categories.admin.index');
        Route::get('/create',   [CategoryController::class, 'create'])->name('categories.admin.create');
        Route::post('/',        [CategoryController::class, 'store'])->name('categories.admin.store');
        Route::get('/{categoryId}', [CategoryController::class, 'show'])->name('categories.admin.show');
        Route::get('/{categoryId}/edit',  [CategoryController::class, 'edit'])->name('categories.admin.edit');
        Route::post('/{categoryId}',      [CategoryController::class, 'update'])->name('categories.admin.update');
        Route::delete('/{categoryId}',    [CategoryController::class, 'delete'])->name('categories.admin.delete');
    });

    Route::group(['prefix' => 'services'], function () {
        Route::get('/', [ServiceController::class, 'index'])->name('services.admin.index');
        Route::get('/create',        [ServiceController::class, 'create'])->name('services.admin.create');
        Route::post('/bulk-delete',  [ServiceController::class, 'bulkDelete'])->name('services.admin.bulkDelete');
        Route::post('/',        [ServiceController::class, 'store'])->name('services.admin.store');
        Route::get('/{serviceId}', [ServiceController::class, 'show'])->name('services.admin.show');
        Route::get('/{serviceId}/edit',  [ServiceController::class, 'edit'])->name('services.admin.edit');
        Route::post('/{serviceId}',      [ServiceController::class, 'update'])->name('services.admin.update');
        Route::get('/status/{serviceId}',  [ServiceController::class, 'status'])->name('services.admin.status');
        Route::delete('/{serviceId}',      [ServiceController::class, 'delete'])->name('services.admin.delete');
    });

    Route::group(['prefix' => 'service-requests'], function () {
        Route::get('/', [ServiceRequestController::class, 'index'])->name('serviceRequests.admin.index');
        Route::post('/bulk-delete',   [ServiceRequestController::class, 'bulkDelete'])->name('serviceRequests.admin.bulkDelete');
        Route::delete('/{requestId}', [ServiceRequestController::class, 'delete'])->name('serviceRequests.admin.delete');
    });

    Route::group(['prefix' => 'payment-methods'], function () {
        Route::get('/', [PaymentMethodController::class, 'index'])->name('paymentMethods.admin.index');
        Route::get('/status/{methodId}',  [PaymentMethodController::class, 'status'])->name('paymentMethods.admin.status');
    });

    Route::group(['prefix' => 'complaints'], function () {
        Route::get('/', [ComplaintController::class, 'index'])->name('complaints.admin.index');
        Route::get('/{complaintId}', [ComplaintController::class, 'show'])->name('complaints.admin.show');
    });
    Route::group(['prefix' => 'complaint-replies'], function () {
        Route::post('', [ComplaintReplyController::class, 'store'])->name('replies.admin.store');
    });

    Route::group(['prefix' => 'orders'], function () {
        Route::get('/', [OrderController::class, 'index'])->name('orders.admin.index');
        Route::get('/payment-status/{orderId}',  [OrderController::class, 'paymentStatus'])->name('orders.admin.paymentStatus');
        Route::post('/status/{orderId}',  [OrderController::class, 'status'])->name('orders.admin.status');
    });

    Route::group(['prefix' => 'terms'], function () {
        Route::get('/',  [TermsPolicyController::class, 'editTerms'])->name('terms.admin.edit');
        Route::post('/', [TermsPolicyController::class, 'update'])->name('terms.admin.update');
    });

    Route::group(['prefix' => 'policy'], function () {
        Route::get('/',  [TermsPolicyController::class, 'editPolicy'])->name('policy.admin.edit');
    });

    Route::group(['prefix' => 'banners'], function () {
        Route::get('/', [BannerController::class, 'index'])->name('banners.admin.index');
        Route::post('/bulk-delete',  [BannerController::class, 'bulkDelete'])->name('banners.admin.bulkDelete');
        Route::post('/',             [BannerController::class, 'store'])->name('banners.admin.store');
        Route::get('/{bannerId}',    [BannerController::class, 'show'])->name('banners.admin.show');
        Route::post('/{bannerId}',        [BannerController::class, 'update'])->name('banners.admin.update');
        Route::get('/status/{bannerId}',  [BannerController::class, 'status'])->name('banners.admin.status');
        Route::delete('/{bannerId}',      [BannerController::class, 'delete'])->name('banners.admin.delete');
    });
});
