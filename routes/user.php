<?php

use App\Http\Controllers\Admin\CountryController;
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
// Profile Controller
use App\Http\Controllers\User\ProfileController;

// Invoice
use App\Http\Controllers\User\InvoiceController;
use App\Http\Controllers\User\KnowledgebaseDashboardController;
use App\Http\Controllers\User\PaymentMethods\Stripe\StripeController;
use App\Http\Controllers\User\PaymentMethods\NgeniusNetwork\NgeniusNetworkController;

// Support Tickets
use App\Http\Controllers\User\SupportTicketController;

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

    // Search Countries
    Route::get('search-countries', [CountryController::class, 'searchCountries'])
        ->name('search.countries');

    // Invoice
    Route::get('invoices', [InvoiceController::class, 'index'])
        ->name('invoice.index');
    Route::get('invoices/{id}', [InvoiceController::class, 'show'])
        ->name('invoice.show');

    // Payment Methods
    Route::prefix('payment-method')->name('payment-method.')->group(function () {
        // Stripe Payment Intent
        Route::post('stripe/process-payment', [StripeController::class, 'processPayment'])->name('stripe.process-payment');
        Route::post('stripe/handle-payment-confirmation', [StripeController::class, 'handlePaymentConfirmation'])->name('stripe.handle-payment-confirmation');
        // Stripe Hosted Checkout
        Route::post('stripe/hosted-checkout', [StripeController::class, 'hostedCheckout'])->name('stripe.hosted.checkout');

        // N-Genius Network Payment Intent
        Route::post('ngenius-network/process-payment', [NgeniusNetworkController::class, 'processPayment'])
            ->name('ngenius-network.process-payment');
        Route::post('ngenius-network/handle-payment-confirmation', [NgeniusNetworkController::class, 'handlePaymentConfirmation'])
            ->name('ngenius-network.handle-payment-confirmation');
        // N-Genius Network Hosted Checkout
        Route::post('ngenius-network/hosted-checkout', [NgeniusNetworkController::class, 'hostedCheckout'])
            ->name('ngenius-network.hosted.checkout');
        Route::get('ngenius-network', [NgeniusNetworkController::class, 'handleHostedPaymentConfirmation'])
            ->name('ngenius-network.handle-hosted-payment-confirmation');
    });


    // Support Ticket
    Route::resource('support-tickets', SupportTicketController::class);

    // Support Ticket Reply
    Route::post('support-tickets-reply/{supportTicketId}', [SupportTicketController::class, 'ticketReply'])
        ->name('support-tickets.reply');

    // Upload attachments for support tickets
    Route::post('support-tickets/upload-attachments', [SupportTicketController::class, 'uploadAttachments'])
        ->name('support-tickets.upload-attachments');

    // Knowledgebase prefix
    Route::prefix('knowledgebase')->name('knowledgebase.')->group(function () {
        // Knowledgebase Dashboard
        Route::get('/', [KnowledgebaseDashboardController::class, 'dashboard'])
            ->name('dashboard');
        // Knowledgebase Categories
        Route::get('/categories/{slug}', [KnowledgebaseDashboardController::class, 'categories'])
            ->name('categories');

        // Knowledgebase Article
        Route::get('/article/{slug}', [KnowledgebaseDashboardController::class, 'article'])
            ->name('article');
    });
});
