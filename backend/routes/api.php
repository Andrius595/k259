<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\LitterController;
use App\Http\Controllers\PrizeController;
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

Route::get('users/points-leaderboard', [UserController::class, 'getPointsLeaderboard']);


Route::get('trash-types', [TrashTypeController::class, 'index']);
Route::get('litters', [LitterController::class, 'index']);
Route::get('events', [EventController::class, 'index']);
Route::get('companies', [CompanyController::class, 'index']);
Route::get('prizes', [PrizeController::class, 'index']);

Route::group(['middleware' => ['auth:sanctum']], static function () {
    Route::get('user', [AuthController::class, 'user']);
    Route::get('roles', [AuthController::class, 'roles']);
    Route::get('permissions', [AuthController::class, 'permissions']);

    Route::group(['prefix' => 'users'], static function () {
        Route::post('update-profile', [UserController::class, 'updateProfile']);
    });


    Route::apiResource('litters', LitterController::class)->except(['index']);
    Route::group(['prefix' => 'litters'], static function () {
        Route::post('{litter}/cleaned', [LitterController::class, 'markLitterAsCleaned']);
    });

    Route::apiResource('events', EventController::class)->except(['index']);
    Route::group(['prefix' => 'events'], static function () {
        Route::post('{event}/end', [EventController::class, 'markEventAsEnded']);
        Route::post('{event}/join', [EventController::class, 'joinEvent']);
    });

    Route::apiResource('companies', CompanyController::class)->except(['index']);

    Route::apiResource('prizes', PrizeController::class)->except(['index']);
});
