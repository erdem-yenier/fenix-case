<?php

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

Route::group([

    'middleware' => 'api',
    'namespace' => 'App\Http\Controllers\Api',
    'prefix' => 'v1'
    
], function ($router) {

    Route::post('/auth' , 'AuthController@index')->name('auth');
    Route::get('/subscription/list' , 'SubscriptionController@list')->name('subscription.list');
    Route::post('/subscription' , 'SubscriptionController@subscription')->middleware('auth.login.check')->name('subscription');
    Route::post('/chat' , 'ChatController@index')->middleware('auth.login.check')->name('chat');
    

});