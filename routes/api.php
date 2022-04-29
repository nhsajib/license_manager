<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'user'], function() {
    Route::post('login', [App\Http\Controllers\Auth\AuthController::class, 'login']);
    Route::post('logout', [App\Http\Controllers\Auth\AuthController::class, 'logout']);
    Route::post('refresh', [App\Http\Controllers\Auth\AuthController::class, 'refresh']);
    Route::get('me', [App\Http\Controllers\Auth\AuthController::class, 'me']);
    // Route::post('register', [App\Http\Controllers\Auth\AuthController::class, 'register']);
    Route::put('update', [App\Http\Controllers\Auth\AuthController::class, 'update']);
    Route::put('change/password', [App\Http\Controllers\Auth\AuthController::class, 'changePassword']);

});

Route::group(['middleware' => ['auth:api', 'isSuper'], 'prefix' => 'supadm'], function(){

    Route::get('super/seller/index', [App\Http\Controllers\SupperSellerController::class, 'index']);
    Route::post('super/seller/store', [App\Http\Controllers\SupperSellerController::class, 'store']);
    Route::put('super/seller/update', [App\Http\Controllers\SupperSellerController::class, 'update']);
    Route::delete('super/seller/delete/{id}', [App\Http\Controllers\SupperSellerController::class, 'destroy']);

    Route::get('seller/index', [App\Http\Controllers\SellerController::class, 'index']);
    Route::post('seller/store', [App\Http\Controllers\SellerController::class, 'store']);
    Route::put('seller/update', [App\Http\Controllers\SellerController::class, 'update']);
    Route::delete('seller/delete/{id}', [App\Http\Controllers\SellerController::class, 'destroy']);

    Route::delete('license/destroy/{id}', [App\Http\Controllers\LicenseController::class, 'destroy']);

    Route::get('seller/by/super-seller-id/{id}', [App\Http\Controllers\SellerDetailsController::class, 'sellersBySupSellerId']);
    Route::get('license/by/seller-id/{id}', [App\Http\Controllers\SellerDetailsController::class, 'licenseBySupSeller']);

    Route::get('software/info/get', [App\Http\Controllers\SoftwateInfoController::class, 'get']);
    Route::put('software/info/update', [App\Http\Controllers\SoftwateInfoController::class, 'update']);

});

Route::group(['middleware' => 'auth:api'], function(){

    Route::get('license/index', [App\Http\Controllers\LicenseController::class, 'index']);
    Route::post('license/store', [App\Http\Controllers\LicenseController::class, 'store']);
    Route::put('license/active/{id}', [App\Http\Controllers\LicenseController::class, 'active']);
    Route::put('license/deactive/{id}', [App\Http\Controllers\LicenseController::class, 'deactive']);
    Route::get('users/all', [App\Http\Controllers\FormDataController::class, 'users']);
    Route::put('license/renew/{id}', [App\Http\Controllers\LicenseController::class, 'renewId']);
    Route::post('credit/transfer', [App\Http\Controllers\TransferCreditController::class, 'transfer']);

});

Route::get('software/information', [App\Http\Controllers\SoftwateInfoController::class, 'getInfo']);