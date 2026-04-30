<?php

use App\Http\Controllers\Auth\SessionController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::post('/register', [SessionController::class, 'register'])->name('register');
    Route::post('/login', [SessionController::class, 'login'])->name('login');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/{product}', [ProductController::class, 'show'])->missing(function () {
        return response()->json(['message' => 'Not Found'], 404);
    });
    Route::post('/products', [ProductController::class, 'store']);
    Route::patch('/products/{product}', [ProductController::class, 'update']);
    Route::delete('/products/{product}', [ProductController::class, 'destroy']);

    Route::get('/company', [CompanyController::class, 'show']);
    Route::post('/company', [CompanyController::class, 'update']);
    Route::delete('/company', [CompanyController::class, 'destroy']);

    Route::post('/logout', [SessionController::class, 'logout'])->name('logout');
});
