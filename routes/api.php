<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FunkosController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::prefix('categories')->group(function () {
    Route::get('/', [CategoryController::class, 'findAll']);
    Route::get('/{id}', [CategoryController::class, 'findById']);
    Route::post('/', [CategoryController::class, 'create']);
    Route::put('/{id}', [CategoryController::class, 'update']);
    Route::delete('/{id}', [CategoryController::class, 'destroy']);
});

Route::prefix('funkos')->group(function () {
    Route::get('/', [FunkosController::class, 'findAll']);
    Route::get('/{id}', [FunkosController::class, 'findById']);
    Route::post('/', [FunkosController::class, 'create']);
    Route::put('/{id}', [FunkosController::class, 'update']);
    Route::patch('/imagen/{id}', [FunkosController::class, 'updateImage']);
    Route::delete('/{id}', [FunkosController::class, 'destroy']);
});

