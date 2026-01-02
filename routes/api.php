<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Public routes
Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
});

// Protected routes
Route::middleware('auth:api')->group(function () {
    Route::post('auth/logout', [AuthController::class, 'logout']);

    // Admin only routes
    Route::middleware('role:admin,superadmin')->prefix('admin')->group(function () {
        Route::get('dashboard', function () {
            return response()->json(['message' => 'Welcome to the Admin Dashboard']);
        });
    });

    // Superadmin only routes
    Route::middleware('role:superadmin')->prefix('superadmin')->group(function () {
        Route::get('dashboard', function () {
            return response()->json(['message' => 'Welcome to the Superadmin Dashboard']);
        });
    });
});
