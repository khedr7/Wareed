<?php

use App\Http\Controllers\CityController;
use App\Http\Controllers\StateController;
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

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', function () {
    return view('home');
})->name('home')->middleware('auth');


Route::group(['middleware' => 'auth'], function () {
    Route::resource('user', UserController::class);

    Route::group(['prefix' => 'users'], function () {
        Route::get('/', [UserController::class, 'index'])->name('users.admin.index');
        Route::get('/create',        [UserController::class, 'create'])->name('users.admin.create');
        Route::post('/bulk-delete',  [UserController::class, 'bulkDelete'])->name('users.admin.bulkDelete');
        Route::post('/',        [UserController::class, 'store'])->name('users.admin.store');
        Route::get('/{userId}', [UserController::class, 'show'])->name('users.admin.show');
        Route::get('/{userId}/edit',  [UserController::class, 'edit'])->name('users.admin.edit');
        Route::post('/{userId}',      [UserController::class, 'update'])->name('users.admin.update');
        Route::get('/status/{userId}',  [UserController::class, 'status'])->name('users.admin.status');
        Route::delete('/{userId}',      [UserController::class, 'delete'])->name('users.admin.delete');
    });

    Route::group(['prefix' => 'states'], function () {
        Route::get('/', [StateController::class, 'index'])->name('states.admin.index');
        Route::get('/{stateId}/cities', [StateController::class, 'getCities'])->name('states.admin.cities');
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
        Route::get('/{userId}', [CityController::class, 'show'])->name('cities.admin.show');
        Route::get('/{userId}/edit',  [CityController::class, 'edit'])->name('cities.admin.edit');
        Route::post('/{userId}',      [CityController::class, 'update'])->name('cities.admin.update');
        Route::get('/status/{userId}',  [CityController::class, 'status'])->name('cities.admin.status');
        Route::delete('/{userId}',      [CityController::class, 'delete'])->name('cities.admin.delete');
    });
});
