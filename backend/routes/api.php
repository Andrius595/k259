<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\LitterController;
use App\Http\Controllers\UserController;
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

Route::group(['middleware' => ['auth:sanctum']], static function () {
    Route::get('user', [AuthController::class, 'user']);

    Route::group(['prefix' => 'users'], static function () {
        Route::post('update-profile', [UserController::class, 'updateProfile']);
    });

    Route::apiResource('litter', LitterController::class);
    Route::post('litter/{litter}/cleaned', [LitterController::class, 'markLitterAsCleaned']);
});
