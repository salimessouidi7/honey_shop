<?php

use App\Http\Controllers\Api\Admin\UserController as ApiAdminUserController;
use App\Http\Controllers\Api\AuthController as ApiAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Public - no token needed yet, this is how you get one
Route::post('/login', [ApiAuthController::class, 'login']);

// Everything below requires a valid Bearer token (Authorization: Bearer {token})
Route::middleware('auth:sanctum')->group(function () {

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/logout', [ApiAuthController::class, 'logout']);

    // Same 'role' middleware you already use on the web side - it works
    // identically here since it just checks auth()->user()->role
    Route::middleware('role:admin,staff')->group(function () {
        Route::get('/admin/users', [ApiAdminUserController::class, 'index']);
    });
});
