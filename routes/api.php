<?php

use App\Http\Controllers\Auth\SessionController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ProductController;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return new UserResource($request->user());
})->middleware('auth:sanctum');

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

    Route::singleton('company', CompanyController::class)->creatable();

    Route::post('/logout', [SessionController::class, 'logout'])->name('logout');
});
