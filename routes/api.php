<?php

use App\Http\Controllers\Auth\ApiAuthController;
use App\Http\Controllers\Posts\PostsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;

Route::prefix('v1')->group(function() {
    Route::post('/register', [ApiAuthController::class, 'register'])
        ->middleware('guest');

    Route::post('/login', [ApiAuthController::class, 'login'])
        ->middleware('guest');

    Route::post('/logout', [ApiAuthController::class, 'logout'])
        ->middleware('auth:sanctum');

    Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
        return $request->user();
    });

    Route::prefix('posts')->middleware('auth:sanctum')->group(function () {
        Route::get('/list', [PostsController::class, 'list']);
        Route::post('/store', [PostsController::class, 'store']);
        Route::put('/edit/{id}', [PostsController::class, 'edit']);
        Route::delete('/delete', [PostsController::class, 'delete']);
    });

});
