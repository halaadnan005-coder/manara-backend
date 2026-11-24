<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Admin\UserManagementController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\WorldManagementController;

Route::post('/register', [RegisteredUserController::class, 'store']);

Route::post('/login', [AuthenticatedSessionController::class, 'store']);

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy']);

    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::middleware('admin')->group(function () {

        Route::get('/admin/users/statistics', [UserManagementController::class, 'statistics']);
        Route::get('/admin/users', [UserManagementController::class, 'index']);
        Route::delete('/admin/users/{id}', [UserManagementController::class, 'destroy']);
        Route::get('/admin/worlds/statistics', [WorldManagementController::class, 'statistics']);
        Route::get('/admin/worlds', [WorldManagementController::class, 'index']);
        Route::post('/admin/worlds', [WorldManagementController::class, 'store']);
        Route::put('/admin/worlds/{id}', [WorldManagementController::class, 'update']);
        Route::patch('/admin/worlds/{id}/status', [WorldManagementController::class, 'toggleStatus']);
        Route::delete('/admin/worlds/{id}', [WorldManagementController::class, 'destroy']);

    });
    
});
