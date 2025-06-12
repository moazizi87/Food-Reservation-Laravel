<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FoodController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin Routes
    Route::middleware(['role:admin'])->group(function () {
        Route::resource('foods', FoodController::class);
        Route::resource('categories', CategoryController::class);
        Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.status');
    });
    
    // Student Routes
    Route::middleware(['role:student'])->group(function () {
        Route::get('/menu', [FoodController::class, 'menu'])->name('foods.menu');
    });
    
    // Common Routes
    Route::resource('orders', OrderController::class);
});

require __DIR__.'/auth.php';
