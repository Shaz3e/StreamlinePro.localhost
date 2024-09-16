<?php

namespace App\Providers;

use App\Models\Admin;
use App\Models\Company;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Promotion;
use App\Models\SupportTicket;
use App\Models\SupportTicketReply;
use App\Models\Task;
use App\Models\TaskComment;
use App\Models\User;
use App\Observers\CompanyObserver;
use App\Observers\InvoiceObserver;
use App\Observers\PaymentObserver;
use App\Observers\PromotionObserver;
use App\Observers\StaffObserver;
use App\Observers\SupportTicketObserver;
use App\Observers\SupportTicketReplyObserver;
use App\Observers\TaskCommentObserver;
use App\Observers\TaskObserver;
use App\Observers\UserObserver;
use Illuminate\Support\ServiceProvider;

class ObserverServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // User
        User::observe(UserObserver::class);

        // Admin / Staff
        Admin::observe(StaffObserver::class);

        // Company
        Company::observe(CompanyObserver::class);

        // Task
        Task::observe(TaskObserver::class);

        // Task Comment
        TaskComment::observe(TaskCommentObserver::class);

        // Invoice
        Invoice::observe(InvoiceObserver::class);
        Payment::observe(PaymentObserver::class);

        // Support Ticket
        SupportTicket::observe(SupportTicketObserver::class);

        // Support Ticket Reply
        SupportTicketReply::observe(SupportTicketReplyObserver::class);

        // Promotion
        Promotion::observe(PromotionObserver::class);
    }
}
