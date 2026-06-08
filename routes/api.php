<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ItemController;

Route::prefix('v1')->group(function () {

    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware(['auth:sanctum'])->group(function () {

        Route::apiResource('categories', CategoryController::class)
            ->except(['destroy']);

        Route::apiResource('items', ItemController::class)
            ->except(['destroy']);

        Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])
            ->middleware('role:admin');

        Route::delete('/items/{id}', [ItemController::class, 'destroy'])
            ->middleware('role:admin');
    });

});