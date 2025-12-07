<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ServiceCenterController;

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


/***************************** API ROUTES **********************************/

// Route::controller(AuthController::class)->name('api.')->group(function () {
//     Route::post('/register', 'register');
//     Route::post('/login', 'login');
//     Route::post('/logout', 'logout')->middleware('auth:sanctum');
//     Route::post('/refresh', 'refresh')->middleware('auth:sanctum');
// });

Route::prefix('service-centers')->controller(ServiceCenterController::class)->group(function () {
    Route::get('/brands/{brand}/cities', 'cities');
    Route::get('/brands/{brand}/cities/{city}/branches', 'branches');
    Route::get('/branches/{branch}', 'branch');
});
