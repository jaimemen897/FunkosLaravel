<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FunkosController;
use Illuminate\Support\Facades\Route;


Route::prefix('api')->group(function () {

    Route::get('/', function () {
        return view('welcome');
    });

    Route::prefix('categories')->group(function () {
        Route::get('/', [CategoryController::class, 'index']);
        Route::get('/{id}', [CategoryController::class, 'show']);
        Route::post('/', [CategoryController::class, 'store']);
        Route::put('/{id}', [CategoryController::class, 'edit']);
        Route::delete('/{id}', [CategoryController::class, 'destroy']);
    });

    Route::prefix('funkos')->group(function () {
        Route::get('/', [FunkosController::class, 'index']);
        Route::get('/{id}', [FunkosController::class, 'show']);
        Route::post('/', [FunkosController::class, 'store']);
        Route::put('/{id}', [FunkosController::class, 'edit']);
        Route::delete('/{id}', [FunkosController::class, 'destroy']);
    });
});
