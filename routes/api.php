<?php

use Illuminate\Http\Request;
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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::post('login', 'Auth\AuthController@login');

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('users', 'Api\UserController');
    Route::apiResource('contacts', 'Api\ContactController');
    Route::post('contacts/search', 'Api\ContactController@search');
    Route::apiResource('emails', 'Api\EmailController');
    Route::apiResource('campaigns', 'Api\CampaignController');
});
