<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|-------------------------------------------------------------------------
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
*/

// post /app/user
// post /app/user/auth
// get /app/sites/list/?user={userid}
// post /app/sites?user={userid}
Route::prefix('app')->group(function () {
    Route::post('user', UserController::class . '@register');
    Route::post('user/auth', UserController::class . '@auth');

    Route::get('sites/list/', UserController::class . '@list');
    Route::post('sites', UserController::class . '@create');
});