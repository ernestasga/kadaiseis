<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\ShowController;
use App\Http\Controllers\Admin\UserController;
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
Auth::routes();

Route::group(
    [
        'middleware' => ['auth', 'admin'],
        'prefix' => 'admin'
    ],
    function () {
        Route::get('/', [AdminController::class, 'index']);
        Route::get('users', [AdminController::class, 'users']);

        Route::put('users/updateRole', [UserController::class, 'updateRole']);
        Route::delete('users/delete', [UserController::class, 'delete']);

        Route::get('settings', [SettingsController::class, 'index']);
        Route::put('settings/update', [SettingsController::class, 'update']);

        Route::get('shows', [AdminController::class, 'shows']);
        Route::post('shows/store', [ShowController::class, 'store']);
        Route::put('shows/updateIsPopular', [ShowController::class, 'updateIsPopular']);
        Route::delete('shows/delete', [ShowController::class, 'delete']);
});

Route::fallback(function() {
    return view('index');
});
