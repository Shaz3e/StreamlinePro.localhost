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

// Profile
use App\Http\Controllers\Admin\ProfileController;

// Todos
use App\Http\Controllers\Admin\TodoController;

// Todo Label
use App\Http\Controllers\Admin\TodoLabelController;

// Tasks
use App\Http\Controllers\Admin\TaskController;

// Task Label
use App\Http\Controllers\Admin\TaskLabelController;

// Users
use App\Http\Controllers\Admin\UserController;

// Companies
use App\Http\Controllers\Admin\CompanyController;

// Promotions
use App\Http\Controllers\Admin\PromotionController;

// Products
use App\Http\Controllers\Admin\ProductController;

// Knowledgebase
use App\Http\Controllers\Admin\Knowledgebase\KnowledgebaseCategoryController;
use App\Http\Controllers\Admin\Knowledgebase\KnowledgebaseArticleController;

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
use App\Http\Controllers\Admin\InvoiceController;

// Invoice Status
use App\Http\Controllers\Admin\InvoiceLabelController;

/**
 * Settings
 */

use App\Http\Controllers\Admin\AppSetting\AppSettingController;
use App\Http\Controllers\Admin\AppSetting\GeneralSettingController;
use App\Http\Controllers\Admin\AppSetting\AuthenticationSettingController;
use App\Http\Controllers\Admin\AppSetting\DashboardSettingController;
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

        // Profile
        Route::get('my-profile', [ProfileController::class, 'profile'])
            ->name('profile');
        Route::post('my-profile', [ProfileController::class, 'profileStore'])
            ->name('profile.store');

        // App Settings
        Route::resource('app-settings', AppSettingController::class);

        Route::prefix('settings')->name('settings.')->group(function () {
            // General Setting
            Route::get('', [GeneralSettingController::class, 'general'])->name('general');
            Route::post('', [GeneralSettingController::class, 'generalStore'])->name('general.store');

            // Registration Setting
            Route::get('authentication', [AuthenticationSettingController::class, 'authentication'])->name('authentication');
            Route::post('authentication', [AuthenticationSettingController::class, 'authenticationStore'])->name('authentication.store');

            // Dashboard Setting
            Route::get('dashboard', [DashboardSettingController::class, 'dashboard'])->name('dashboard');
            Route::post('dashboard', [DashboardSettingController::class, 'dashboardStore'])->name('dashboard.store');
        });

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

        // Update Status
        Route::patch('tasks/{id}/update-status', [TaskController::class, 'updateStatus'])
            ->name('tasks.updatestatus');

        // Audit
        Route::get('tasks-audit/{id}', [TaskController::class, 'audit'])
            ->name('tasks.audit');
        Route::get('tasks-audit/delete/{id}', [TaskController::class, 'deleteAudit'])
            ->name('tasks.audit.delete');

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
        Route::resource('invoices', InvoiceController::class);
        // Audit
        Route::get('invoices-audit/{id}', [InvoiceController::class, 'audit'])
            ->name('invoices.audit');
        Route::get('invoices-audit/delete/{id}', [InvoiceController::class, 'deleteAudit'])
            ->name('invoices.audit.delete');
        // Remove Product
        Route::delete('/invoices/products/{productId}/remove', [InvoiceController::class, 'removeProduct'])
            ->name('product.remove');
        // Add Payment
        Route::post('invoice/add-payment/{id}', [InvoiceController::class, 'addPayment'])
            ->name('invoice.add-payment');
        Route::delete('invoice/remove-payment/{id}', [InvoiceController::class, 'removePayment'])
            ->name('invoice.remove-payment');


        /**
         * Users
         */
        Route::resource('users', UserController::class);
        // Search Users
        Route::get('search-users', [UserController::class, 'searchUsers'])
            ->name('search.users');

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

        // Knowledgebase Category & Article
        Route::prefix('knowledgebase')->name('knowledgebase.')->group(function () {
            Route::resource('categories', KnowledgebaseCategoryController::class);
            // Audit
            Route::get('category-audit/{id}', [KnowledgebaseCategoryController::class, 'audit'])
                ->name('category.audit');
            Route::get('category-audit/delete/{id}', [KnowledgebaseCategoryController::class, 'deleteAudit'])
                ->name('category.audit.delete');

            Route::resource('articles', KnowledgebaseArticleController::class);
            // Audit
            Route::get('article-audit/{id}', [KnowledgebaseArticleController::class, 'audit'])
                ->name('article.audit');
            Route::get('article-audit/delete/{id}', [KnowledgebaseArticleController::class, 'deleteAudit'])
                ->name('article.audit.delete');
        });

        /**
         * Admins as Staff
         */
        // Staff List
        Route::resource('staff', StaffController::class);
        Route::get('staff-search', [StaffController::class, 'searchStaff'])
            ->name('search.staff');
        // Audit
        Route::get('staff-audit/{id}', [UserController::class, 'audit'])
            ->name('staff.audit');
        Route::get('staff-audit/delete/{id}', [UserController::class, 'deleteAudit'])
            ->name('staff.audit.delete');

        /**
         * Departments
         */
        Route::resource('departments', DepartmentController::class);
        // Search Department
        Route::get('search-departments', [DepartmentController::class, 'searchDepartments'])
            ->name('search.departments');

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
        Route::resource('todo-labels', TodoLabelController::class);
        // Audit
        Route::get('todo-labels-audit/{id}', [TodoLabelController::class, 'audit'])
            ->name('todo-labels.audit');
        Route::get('todo-labels-audit/delete/{id}', [TodoLabelController::class, 'deleteAudit'])
            ->name('todo-labels.audit.delete');

        /**
         * Task Label
         */
        Route::resource('task-labels', TaskLabelController::class);
        // Audit
        Route::get('task-labels-audit/{id}', [TaskLabelController::class, 'audit'])
            ->name('task-labels.audit');
        Route::get('task-labels-audit/delete/{id}', [TaskLabelController::class, 'deleteAudit'])
            ->name('task-labels.audit.delete');

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
         * Invoice Label
         */
        Route::resource('invoice-labels', InvoiceLabelController::class);
        // Audit
        Route::get('invoice-labels-audit/{id}', [InvoiceLabelController::class, 'audit'])
            ->name('invoice-labels.audit');
        Route::get('invoice-labels-audit/delete/{id}', [InvoiceLabelController::class, 'deleteAudit'])
            ->name('invoice-labels.audit.delete');
    });
});
