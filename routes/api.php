<?php

use App\Http\Controllers\RoleController;
use App\Http\Controllers\StatusController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');



Route::prefix('v2')->group(function () {
    Route::prefix('roles')->group(function () {
        Route::post('/', [RoleController::class, 'store']);
        Route::get('/', [RoleController::class, 'index']);
        Route::get('/{id}', [RoleController::class, 'show']);
        Route::put('/{id}', [RoleController::class, 'update']);
        Route::delete('/{id}', [RoleController::class, 'destroy']);
    });
    Route::prefix('statuses')->group(function () {
        Route::post('/', [StatusController::class, 'store']);
        Route::get('/', [StatusController::class, 'index']);
        Route::get('/{id}', [StatusController::class, 'show']);
        Route::put('/{id}', [StatusController::class, 'update']);
        Route::delete('/{id}', [StatusController::class, 'destroy']);
    });
});
