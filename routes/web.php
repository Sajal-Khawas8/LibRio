<?php

use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

Route::controller(LoginController::class)->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/login', 'create')->name('login');
        Route::post('/login', 'store');
        Route::get('/forgot-password', 'forgotPasswordForm')->name('forgot-password');
        Route::post('/forgot-password', 'forgotPassword')->name('forgot-password');
        Route::get('/reset-password/{token}', 'resetPasswordForm')->name('password.reset');
        Route::post('/reset-password', 'resetPassword')->name('password.update');
    });

    Route::post('/logout', 'destroy')->middleware('auth');
});

require __DIR__ . '/admin.php';

require __DIR__ . '/client.php';
