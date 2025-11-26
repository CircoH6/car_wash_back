<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AbonnementController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\AuthentificatedController;
use App\Http\Controllers\ReservationController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::post('/register', [AuthentificatedController::class, 'register']);
Route::post('/login', [AuthentificatedController::class, 'login']);
Route::delete('/logout', [AuthentificatedController::class, 'logout'])->middleware('auth:api');

Route::get('/index', [ServiceController::class, 'index']);
Route::get('/index', [ReservationController::class, 'index']);
Route::get('/index', [AbonnementController::class, 'index']);

Route::middleware('auth:api')->group(function(){
    Route::prefix('/services')->group(function () {
        Route::post('/store', [ServiceController::class, 'store']);
        Route::get('/show', [ServiceController::class, 'show']);
        Route::put('/update/{id}', [ServiceController::class, 'update']);
        Route::delete('/destroy/{id}', [ServiceController::class, 'destroy']);
    });

    Route::prefix('/reservations')->group(function () {
        Route::post('/store', [ReservationController::class, 'store']);
        Route::get('/show{id}', [ReservationController::class, 'show']);
        Route::put('update/{id}', [ReservationController::class, 'update']);
        Route::delete('destroy/{id}', [ReservationController::class, 'destroy']);
    });

    Route::prefix('/abonnements')->group(function () {
        Route::post('/store', [AbonnementController::class, 'store']);
        Route::get('/show{id}', [AbonnementController::class, 'show']);
        Route::put('update/{id}', [AbonnementController::class, 'update']);
        Route::delete('destroy/{id}', [AbonnementController::class, 'destroy']);
    });

});

