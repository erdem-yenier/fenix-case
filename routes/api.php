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

Route::group([

    'namespace' => 'App\Http\Controllers\Dash',
    'prefix' => 'dashboard'
    
], function ($router) {

    Route::post('register', 'OwnerAuthController@register')->name('register');
    Route::post('login', 'OwnerAuthController@login')->name('login');
    Route::post('logout', 'OwnerAuthController@logout')->middleware('auth:sanctum')->name('logout');

    Route::get('/list' , 'DashIndexController@list')->middleware('auth:sanctum')->name('order.list');
    
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