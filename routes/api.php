<?php

use App\Http\Controllers\Auth\SessionController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('guest')->group(function () {
    Route::post('/register', [SessionController::class, 'register'])->name('register');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/{product}', [ProductController::class, 'show'])->missing(function () {
        return response()->json(['message' => 'Not Found'], 404);
    });
    Route::post('/products', [ProductController::class, 'store']);
    Route::patch('/products/{product}', [ProductController::class, 'update']);
    Route::delete('/products/{product}', [ProductController::class, 'destroy']);
});

Route::post('/companies', [CompanyController::class, 'store'])->middleware('auth:sanctum');
