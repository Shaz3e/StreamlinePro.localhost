<?php

use Illuminate\Support\Facades\Route;

// Admin Auth
use App\Http\Controllers\Admin\Auth\RegisterController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\Auth\ResetPasswordController;
use App\Http\Controllers\Admin\Auth\LogoutController;

// Admin Dashboard
use App\Http\Controllers\Admin\DashboardController;

// Todos

// Todo Status

// Tasks

// Task Status

// Users
use App\Http\Controllers\Admin\UserController;

// Companies

// Promotions

// Products

// Support Ticket Priority

// Support Ticket Status

// Support Tickets

// Admins

// Departments

// Invoice

// Invoice Status

// if route is /admin redirect to admin/dashboard

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest:admin')->group(function () {

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

    Route::middleware('auth:admin')->group(function () {

        // Logout
        Route::post('logout', [LogoutController::class, 'logout'])
            ->name('logout');

        // Dashboard
        Route::get('/', [DashboardController::class, 'dashboard'])
            ->name('dashboard');

        /**
         * Todos
         */
        // Todo List
        Route::get('todos', function () {
        })->name('todos');
        // Todo Create
        Route::get('todo/create', function () {
        })->name('todos.create');
        // Todo Edit
        Route::get('todo/{id}/edit', function () {
        })->name('todos.edit');
        // Todo Show
        Route::get('todo/{id}', function () {
        })->name('todos.show');

        /**
         * Todo Status
         */

        // Todo Status List
        Route::get('todos/status', function () {
        })->name('todo-status');
        // Todo Status Create
        Route::get('todo/status/create', function () {
        })->name('todo-status.create');
        // Todo Status Edit
        Route::get('todo/status/{id}/edit', function () {
        })->name('todo-status.edit');

        /**
         * Tasks
         */

        // Task List
        Route::get('tasks', function () {
        })->name('tasks');
        // // Task Create
        Route::get('task/create', function () {
        })->name('tasks.create');
        // // Task Edit
        Route::get('task/{id}/edit', function () {
        })->name('tasks.edit');
        // // Task Show
        Route::get('task/{id}', function () {
        })->name('tasks.show');

        /**
         * Task Status
         */

        // Task Status List
        Route::get('tasks/status', function () {
        })->name('task-status');
        // Task Status Create
        Route::get('task/status/create', function () {
        })->name('task-status.create');
        // Task Status Edit
        Route::get('task/status/{id}/edit', function () {
        })->name('task-status.edit');
        // Task Status Show
        Route::get('task/status/{id}', function () {
        })->name('task-status.show');

        /**
         * Users
         */
        Route::resource('users', UserController::class);
        // Audit
        Route::get('/users-audit/{id}', [UserController::class, 'audit'])
            ->name('users.audit');
        Route::get('/users-audit/delete/{id}', [UserController::class, 'deleteAudit'])
            ->name('users.audit.delete');
        // Restore users
        Route::post('/users/restore/{id}', [UserController::class, 'restore'])
            ->name('users.restore');
        // Force Delete users
        Route::post('/users/force-delete/{id}', [UserController::class, 'forceDelete'])
            ->name('users.forceDelete');

        /**
         * Companies
         */
        // Company List
        Route::get('companies', function () {
        })->name('companies');
        // Company Create
        Route::get('companies/create', function () {
        })->name('companies.create');
        // Company Edit
        Route::get('companies/{id}/edit', function () {
        })->name('companies.edit');
        // Company Show
        Route::get('companies/{id}', function () {
        })->name('companies.show');

        /**
         * Promotions
         */
        // Promotion List
        Route::get('promotions', function () {
        })->name('promotions');
        // Promotion Create
        Route::get('promotions/create', function () {
        })->name('promotions.create');
        // // Promotion Edit
        Route::get('promotions/{id}/edit', function () {
        })->name('promotions.edit');
        // // Promotion Show
        Route::get('promotions/{id}', function () {
        })->name('promotions.show');

        /**
         * Products
         */
        // Product List
        Route::get('products', function () {
        })->name('products');
        // Product Create
        Route::get('products/create', function () {
        })->name('products.create');
        // Product Edit
        Route::get('products/{id}/edit', function () {
        })->name('products.edit');
        // Product Show
        Route::get('products/{id}', function () {
        })->name('products.show');

        /**
         * Support Tickets / Status / Priority
         */
        Route::prefix('support-tickets')->name('support-tickets.')->group(function () {
            /**
             * Support Ticket Priority
             */
            // Ticket Priority List
            Route::get('priority', function () {
            })->name('ticket-priority');
            // Ticket Priority Create
            Route::get('priority/create', function () {
            })->name('ticket-priority.create');
            // Ticket Priority Edit
            Route::get('priority/{id}/edit', function () {
            })->name('ticket-priority.edit');
            // Ticket Priority Show
            Route::get('priority/{id}', function () {
            })->name('ticket-priority.show');

            /**
             * Support Ticket Status
             */
            // Ticket Status List
            Route::get('status', function () {
            })->name('ticket-status');
            // Ticket Status Create
            Route::get('status/create', function () {
            })->name('ticket-status.create');
            // Ticket Status Edit
            Route::get('status/{id}/edit', function () {
            })->name('ticket-status.edit');
            // Ticket Status Show
            Route::get('status/{id}', function () {
            })->name('ticket-status.show');

            /**
             * Support Ticket
             */
            // Support Ticket List
            Route::get('/', function () {
            })->name('list');
            // Support Ticket Create
            Route::get('/create', function () {
            })->name('create');
            // Support Ticket Edit
            Route::get('/{id}/edit', function () {
            })->name('edit');
            // Support Ticket Show
            Route::get('/{id}', function () {
            })->name('show');
        });

        /**
         * Admins as Staff
         */
        // Staff List
        Route::get('/staff', function () {
        })->name('staff');
        // Staff Create
        Route::get('/staff/create', function () {
        })->name('staff.create');
        // Staff Edit
        Route::get('/staff/{id}/edit', function () {
        })->name('staff.edit');
        // Staff Show
        Route::get('/staff/{id}', function () {
        })->name('staff.show');

        /**
         * Departments
         */
        // Department List
        Route::get('/departments', function () {
        })->name('departments');
        // Department Create
        Route::get('/departments/create', function () {
        })->name('departments.create');
        // Department Edit
        Route::get('/departments/{id}/edit', function () {
        })->name('departments.edit');
        // Department Show
        Route::get('/departments/{id}', function () {
        })->name('departments.show');

        /**
         * Invoice
         */

        // Invoice List
        Route::get('/invoice', function () {
        })->name('invoices');
        // Invoice Create
        Route::get('/invoice/create', function () {
        })->name('invoices.create');
        // Invoice Edit
        Route::get('/invoice/{id}/edit', function () {
        })->name('invoices.edit');
        // Invoice Show
        Route::get('/invoice/{id}', function () {
        })->name('invoices.show');

        /**
         * Invoice Status
         */

        // Invoice Status List
        Route::get('/invoice-status', function () {
        })->name('invoice-status');
        // Invoice Status Create
        Route::get('/invoice-status/create', function () {
        })->name('invoice-status.create');
        // Invoice Status Edit
        Route::get('/invoice-status/{id}/edit', function () {
        })->name('invoice-status.edit');
        // Invoice Status Show
        Route::get('/invoice-status/{id}', function () {
        })->name('invoice-status.show');
    });
});
