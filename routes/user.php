<?php

use Illuminate\Support\Facades\Route;

// Admin Auth
use App\Http\Controllers\User\Auth\RegisterController;
use App\Http\Controllers\User\Auth\LoginController;
use App\Http\Controllers\User\Auth\ForgotPasswordController;
use App\Http\Controllers\User\Auth\ResetPasswordController;
use App\Http\Controllers\User\Auth\LogoutController;
use App\Http\Controllers\User\Auth\LockController;

// Dashboard
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\InvoiceController;
// Profile Controller
use App\Http\Controllers\User\ProfileController;

Route::middleware('guest')->group(function () {

    // Register
    Route::get('register', [RegisterController::class, 'view'])
        ->name('register');
    Route::post('register', [RegisterController::class, 'post'])
        ->name('register.store');

    // Login
    Route::get('login', [LoginController::class, 'view'])
        ->name('login');
    Route::post('login', [LoginController::class, 'post'])
        ->name('login.store');

    // Forgot Password
    Route::get('forgot-password', [ForgotPasswordController::class, 'view'])
        ->name('forgot.password');
    Route::post('forgot-password', [ForgotPasswordController::class, 'post'])
        ->name('forgot.password.store');

    // Reset Password
    Route::get('reset/{email}/{token}', [ResetPasswordController::class, 'view'])
        ->name('password.reset');
    Route::post('reset', [ResetPasswordController::class, 'post'])
        ->name('password.reset.store');
});

Route::middleware('auth')->group(function () {

    // Lock
    Route::get('lock', [LockController::class, 'view'])
        ->name('lock');
    Route::post('lock', [LockController::class, 'post'])
        ->name('lock.store');

    // Logout
    Route::post('/logout', [LogoutController::class, 'logout'])
        ->name('logout');

    // User Dashboard
    Route::get('/', [DashboardController::class, 'dashboard'])
        ->name('dashboard');

    // Profile
    Route::get('my-profile', [ProfileController::class, 'profile'])
        ->name('profile');
    Route::post('my-profile', [ProfileController::class, 'profileStore'])
        ->name('profile.store');

    // Invoice
    Route::get('invoices', [InvoiceController::class, 'index'])
        ->name('invoice.index');
    Route::get('invoices/{id}', [InvoiceController::class, 'show'])
        ->name('invoice.show');
});
