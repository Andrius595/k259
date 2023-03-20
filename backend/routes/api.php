<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\LitterController;
use App\Http\Controllers\TrashTypeController;
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

    Route::get('trash-types', [TrashTypeController::class, 'index']);

    Route::apiResource('litters', LitterController::class);
    Route::group(['prefix' => 'litters'], static function () {
        Route::post('{litter}/cleaned', [LitterController::class, 'markLitterAsCleaned']);
    });

    Route::apiResource('events', EventController::class);
    Route::group(['prefix' => 'events'], static function () {
        Route::post('{event}/end', [EventController::class, 'markEventAsEnded']);
    });

    Route::apiResource('companies', CompanyController::class);
});
