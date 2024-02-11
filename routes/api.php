<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FunkosController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

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
    Route::patch('/imagen/{id}', [FunkosController::class, 'updateImage']);
    Route::delete('/{id}', [FunkosController::class, 'destroy']);
});

