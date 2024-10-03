<?php

use App\Http\Controllers\Api\AdController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CityController;
use App\Http\Controllers\Api\DistrictController;
use App\Http\Controllers\Api\DomainController;
use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\API\SettingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::controller(AuthController::class)->group(function () {
    Route::post('register', 'register');
    Route::post('login', 'login');
    Route::post('logout', 'logout')->middleware('auth:sanctum');
});
Route::get('/settings/{id}', SettingController::class);
Route::get('/cities', CityController::class);
Route::get('/districts', DistrictController::class);
Route::post('/messages', MessageController::class);
Route::get('/domains', DomainController::class);

Route::middleware('auth:sanctum')->prefix('ads')->controller(AdController::class)->group(function(){
    Route::get('/','index');
    Route::get('/latest','latest');
    Route::get('/doamin/{domain_id}','domain');
    Route::get('/sreach','sreach');
    //User API ads
    Route::middleware('auth:sanctum')->group(function(){
        Route::post('create','create');
        Route::post('updateAd/{id}','update');
        Route::post('delete/{id}', 'delete');
        Route::get('myAds','myAds');
    });
});
