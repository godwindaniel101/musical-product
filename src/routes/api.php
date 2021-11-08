<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\PurchaseController;
use App\Http\Controllers\Api\AuthenticationController;


Route::post('register', [AuthenticationController::class, 'register']); //create new user data
Route::post('auth', [AuthenticationController::class, 'login']); //generate access token for new user
Route::delete('logout', [AuthenticationController::class, 'logout'])->middleware('auth:api'); //invalidate access token

Route::middleware('auth:api')->group(function () { //authenticated routsz

    Route::group(['prefix' => 'user'], function () {
        Route::get('/', [UserController::class, 'index']); //get current user data
        Route::get('/all', [UserController::class, 'allUsers']); //get current user data
        Route::resource('products', PurchaseController::class); //get user product data
    });

    Route::resource('products', ProductController::class); // get product data
});
