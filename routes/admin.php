<?php

use Illuminate\Support\Facades\Route;

// Admin Auth
use App\Http\Controllers\Admin\Auth\RegisterController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\Auth\ResetPasswordController;
use App\Http\Controllers\Admin\Auth\LogoutController;
use App\Http\Controllers\Admin\Auth\LockController;

// Admin Dashboard
use App\Http\Controllers\Admin\DashboardController;

// Todos
use App\Http\Controllers\Admin\TodoController;

// Todo Status
use App\Http\Controllers\Admin\TodoStatusController;

// Tasks
use App\Http\Controllers\Admin\TaskController;

// Task Status
use App\Http\Controllers\Admin\TaskStatusController;

// Users
use App\Http\Controllers\Admin\UserController;

// Companies
use App\Http\Controllers\Admin\CompanyController;

// Promotions
use App\Http\Controllers\Admin\PromotionController;

// Products
use App\Http\Controllers\Admin\ProductController;

// Support Ticket Priority
use App\Http\Controllers\Admin\TicketPriorityController;

// Support Ticket Status
use App\Http\Controllers\Admin\TicketStatusController;

// Support Tickets
use App\Http\Controllers\Admin\SupportTicketController;

// Staff
use App\Http\Controllers\Admin\StaffController;

// Departments
use App\Http\Controllers\Admin\DepartmentController;

// Invoice

// Invoice Status
use App\Http\Controllers\Admin\InvoiceStatusController;

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

        // Lock
        Route::get('lock', [LockController::class, 'view'])
            ->name('lock');
        Route::post('lock', [LockController::class, 'post'])
            ->name('lock.store');

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
        Route::resource('tasks', TaskController::class);
        // Audit
        Route::get('tasks-audit/{id}', [TaskController::class, 'audit'])
            ->name('tasks.audit');
        Route::get('tasks-audit/delete/{id}', [TaskController::class, 'deleteAudit'])
            ->name('tasks.audit.delete');


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
        Route::get('companies-audit/{id}', [CompanyController::class, 'audit'])
            ->name('companies.audit');
        Route::get('companies-audit/delete/{id}', [CompanyController::class, 'deleteAudit'])
            ->name('companies.audit.delete');

        /**
         * Promotions
         */
        Route::resource('promotions', PromotionController::class);
        // Audit
        Route::get('promotions-audit/{id}', [PromotionController::class, 'audit'])
            ->name('promotions.audit');
        Route::get('promotions-audit/delete/{id}', [PromotionController::class, 'deleteAudit'])
            ->name('promotions.audit.delete');

        /**
         * Products
         */
        // Product List
        Route::resource('products', ProductController::class);
        // Audit
        Route::get('products-audit/{id}', [ProductController::class, 'audit'])
            ->name('products.audit');
        Route::get('products-audit/delete/{id}', [ProductController::class, 'deleteAudit'])
            ->name('products.audit.delete');

        /**
         * Support Tickets
         */
        Route::resource('support-tickets', SupportTicketController::class);
        Route::post('support-tickets-reply/{supportTicketId}', [SupportTicketController::class, 'ticketReply'])
            ->name('support-tickets.reply');

        // Upload attachments for support tickets
        Route::post('support-tickets/upload-attachments', [SupportTicketController::class, 'uploadAttachments'])
            ->name('support-tickets.upload-attachments');

        // Audit
        Route::get('support-tickets-audit/{id}', [SupportTicketController::class, 'audit'])
            ->name('support-tickets.audit');
        Route::get('support-tickets-audit/delete/{id}', [SupportTicketController::class, 'deleteAudit'])
            ->name('support-tickets.audit.delete');

        /**
         * Invoice
         */

        // Invoice List
        Route::get('invoice', function () {
        })->name('invoices');
        // Invoice Create
        Route::get('invoice/create', function () {
        })->name('invoices.create');
        // Invoice Edit
        Route::get('invoice/{id}/edit', function () {
        })->name('invoices.edit');
        // Invoice Show
        Route::get('invoice/{id}', function () {
        })->name('invoices.show');

        /**
         * Invoice Status
         */

        // Invoice Status List
        Route::resource('invoice-status', InvoiceStatusController::class);
        // Audit
        Route::get('invoice-status-audit/{id}', [InvoiceStatusController::class, 'audit'])
            ->name('invoice-status.audit');
        Route::get('invoice-status-audit/delete/{id}', [InvoiceStatusController::class, 'deleteAudit'])
            ->name('invoice-status.audit.delete');

        /**
         * Admins as Staff
         */
        // Staff List
        Route::resource('staff', StaffController::class);
        // Audit
        Route::get('staff-audit/{id}', [UserController::class, 'audit'])
            ->name('staff.audit');
        Route::get('staff-audit/delete/{id}', [UserController::class, 'deleteAudit'])
            ->name('staff.audit.delete');

        /**
         * Departments
         */
        Route::resource('departments', DepartmentController::class);
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

        /**
         * Task Status
         */
        Route::resource('task-status', TaskStatusController::class);
        // Audit
        Route::get('task-status-audit/{id}', [TaskStatusController::class, 'audit'])
            ->name('task-status.audit');
        Route::get('task-status-audit/delete/{id}', [TaskStatusController::class, 'deleteAudit'])
            ->name('task-status.audit.delete');
    });
});
