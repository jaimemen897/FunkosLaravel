<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('funkos.index');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('funkos')->group(function () {
    Route::get('/', [App\Http\Controllers\FunkosController::class, 'index'])->name('funkos.index');

    Route::get('/create', [App\Http\Controllers\FunkosController::class, 'store'])->name('funkos.store')->middleware(['auth', 'admin']);
    Route::post('/create', [App\Http\Controllers\FunkosController::class, 'create'])->name('funkos.create')->middleware(['auth', 'admin']);

    Route::get('/{id}', [App\Http\Controllers\FunkosController::class, 'show'])->where('id', '[0-9]+')->name('funkos.show');

    Route::get('/edit/{id}', [App\Http\Controllers\FunkosController::class, 'edit'])->name('funkos.edit')->middleware(['auth', 'admin']);
    Route::put('/edit/{id}', [App\Http\Controllers\FunkosController::class, 'update'])->name('funkos.update')->middleware(['auth', 'admin']);

    Route::get('/editImage/{id}', [App\Http\Controllers\FunkosController::class, 'editImage'])->name('funkos.editImage')->middleware(['auth', 'admin']);
    Route::patch('/editImage/{id}', [App\Http\Controllers\FunkosController::class, 'updateImage'])->name('funkos.updateImage')->middleware(['auth', 'admin']);

    Route::delete('/delete/{id}', [App\Http\Controllers\FunkosController::class, 'destroy'])->name('funkos.destroy')->middleware(['auth', 'admin']);
});

Route::prefix('category')->group(function () {
    Route::get('/', [App\Http\Controllers\CategoryController::class, 'index'])->name('category.index')->middleware(['auth', 'admin']);

    Route::get('/create', [App\Http\Controllers\CategoryController::class, 'store'])->name('category.store')->middleware(['auth', 'admin']);
    Route::post('/create', [App\Http\Controllers\CategoryController::class, 'create'])->name('category.create')->middleware(['auth', 'admin']);

    Route::get('/{id}', [App\Http\Controllers\CategoryController::class, 'show'])->where('id')->name('category.show')->middleware(['auth', 'admin']);

    Route::get('/edit/{id}', [App\Http\Controllers\CategoryController::class, 'edit'])->name('category.edit')->middleware(['auth', 'admin']);
    Route::put('/edit/{id}', [App\Http\Controllers\CategoryController::class, 'update'])->name('category.update')->middleware(['auth', 'admin']);

    Route::delete('/delete/{id}', [App\Http\Controllers\CategoryController::class, 'destroy'])->name('category.destroy')->middleware(['auth', 'admin']);
    Route::patch('/active/{id}', [App\Http\Controllers\CategoryController::class, 'active'])->name('category.active')->middleware(['auth', 'admin']);
});


