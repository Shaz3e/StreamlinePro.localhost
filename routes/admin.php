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
use App\Http\Controllers\Admin\TodoController;

// Todo Status
use App\Http\Controllers\Admin\TodoStatusController;

// Tasks

// Task Status

// Users
use App\Http\Controllers\Admin\UserController;

// Companies
use App\Http\Controllers\Admin\CompanyController;

// Promotions

// Products

// Support Ticket Priority
use App\Http\Controllers\Admin\TicketPriorityController;

// Support Ticket Status
use App\Http\Controllers\Admin\TicketStatusController;

// Support Tickets

// Staff
use App\Http\Controllers\Admin\StaffController;

// Departments
use App\Http\Controllers\Admin\DepartmentController;

// Invoice

// Invoice Status

/**
 * Settings
 */
// Permission
use App\Http\Controllers\Admin\RolePermission\PermissionController;

// Roles
use App\Http\Controllers\Admin\RolePermission\RoleController;

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
        Route::resource('todos', TodoController::class);
        // Audit
        Route::get('todos-audit/{id}', [TodoController::class, 'audit'])
            ->name('todos.audit');
        Route::get('todos-audit/delete/{id}', [TodoController::class, 'deleteAudit'])
            ->name('todos.audit.delete');

        /**
         * Tasks
         */

        // Task List
        Route::get('tasks', function () {
        });

        /**
         * Task Status
         */

        // Task Status List
        Route::get('tasks/status', function () {
        });

        /**
         * Users
         */
        Route::resource('users', UserController::class);
        // Audit
        Route::get('users-audit/{id}', [UserController::class, 'audit'])
            ->name('users.audit');
        Route::get('users-audit/delete/{id}', [UserController::class, 'deleteAudit'])
            ->name('users.audit.delete');

        /**
         * Companies
         */
        Route::resource('companies', CompanyController::class);
        // Audit
        Route::get('/companies-audit/{id}', [CompanyController::class, 'audit'])
            ->name('companies.audit');
        Route::get('/companies-audit/delete/{id}', [CompanyController::class, 'deleteAudit'])
            ->name('companies.audit.delete');

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
        });

        /**
         * Admins as Staff
         */
        // Staff List
        Route::resource('/staff', StaffController::class);
        // Audit
        Route::get('staff-audit/{id}', [UserController::class, 'audit'])
            ->name('staff.audit');
        Route::get('staff-audit/delete/{id}', [UserController::class, 'deleteAudit'])
            ->name('staff.audit.delete');

        /**
         * Departments
         */
        Route::resource('/departments', DepartmentController::class);
        // Audit
        Route::get('departments-audit/{id}', [DepartmentController::class, 'audit'])
            ->name('departments.audit');
        Route::get('departments-audit/delete/{id}', [DepartmentController::class, 'deleteAudit'])
            ->name('departments.audit.delete');

        /**
         * Roles & Permissions
         */
        Route::prefix('roles-permissions')->name('roles-permissions.')->group(function () {
            // Permissions
            Route::resource('permissions', PermissionController::class)->middleware('can:superadmin');
            // Roles
            Route::resource('roles', RoleController::class);
        });

        /**
         * Todo Status
         */
        Route::resource('todo-status', TodoStatusController::class);
        // Audit
        Route::get('todo-status-audit/{id}', [TodoStatusController::class, 'audit'])
            ->name('todo-status.audit');
        Route::get('todo-status-audit/delete/{id}', [TodoStatusController::class, 'deleteAudit'])
            ->name('todo-status.audit.delete');

        /**
         * Support Ticket Status
         */
        Route::resource('ticket-status', TicketStatusController::class);
        // Audit
        Route::get('ticket-status-audit/{id}', [TicketStatusController::class, 'audit'])
            ->name('ticket-status.audit');
        Route::get('ticket-status-audit/delete/{id}', [TicketStatusController::class, 'deleteAudit'])
            ->name('ticket-status.audit.delete');

        /**
         * Support Ticket Priority
         */
        Route::resource('ticket-priority', TicketPriorityController::class);
        // Audit
        Route::get('ticket-priority-audit/{id}', [TicketPriorityController::class, 'audit'])
            ->name('ticket-priority.audit');
        Route::get('ticket-priority-audit/delete/{id}', [TicketPriorityController::class, 'deleteAudit'])
            ->name('ticket-priority.audit.delete');
    });
});
