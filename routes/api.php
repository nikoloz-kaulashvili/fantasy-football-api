<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MarketListingController;
use App\Http\Controllers\Api\PlayerController;
use App\Http\Controllers\Api\TeamController;
use App\Http\Controllers\Api\TransferController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {

    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {

        Route::get('/me', function (Request $request) {
            return $request->user();
        });

        Route::get('/market/listings', [MarketListingController::class, 'index']);
        Route::post('/logout', [AuthController::class, 'logout']);

        Route::get('/team', [TeamController::class, 'show']);
        Route::patch('/team', [TeamController::class, 'update']);
        Route::post('/team/swap', [TeamController::class, 'swap']);
        Route::patch('/players/{player}', [PlayerController::class, 'update']);
        Route::post('/market/listings', [MarketListingController::class, 'store']);
        Route::delete('/market/listings/{listing}', [MarketListingController::class, 'destroy']);
        Route::post('/market/listings/{listing}/buy', [MarketListingController::class, 'buy']);
        Route::get('/transfers', [TransferController::class, 'allTransfers']);
        Route::get('/my-transfers', [TransferController::class, 'myTransfers']);
    });
});
