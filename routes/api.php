<?php

use App\Http\Controllers\Admin\ShowController;
use App\Models\Settings;
use Illuminate\Support\Facades\Cache;
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
/*
Route::get('/social', function() {
    return Cache::remember(
        'social',
        86400,
        function () {
            return response()->json([
                'facebook' => Settings::where('name', 'fbUrl')->pluck('value')[0]
            ]);
    });
});
*/
Route::get('popularShows', [ShowController::class, 'getPopular']);
