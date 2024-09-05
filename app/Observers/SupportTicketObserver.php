<?php

namespace App\Observers;

use App\Jobs\SendEmailJob;
use App\Jobs\SystemNotificationJob;
use App\Mail\System\SupportTicket\CreatedEmail;
use App\Mail\System\SupportTicket\DeletedEmail;
use App\Mail\System\SupportTicket\ForceDeletedEmail;
use App\Mail\System\SupportTicket\RestoredEmail;
use App\Mail\System\SupportTicket\UpdatedEmail;
use App\Mail\User\SupportTicket\CreatedEmail as SupportTicketCreatedEmail;
use App\Models\Admin;
use App\Models\SupportTicket;
use Illuminate\Support\Facades\Mail;

class SupportTicketObserver
{
    /**
     * Handle the SupportTicket "created" event.
     */
    public function created(SupportTicket $supportTicket): void
    {
        // Send Mail to Client
        if (!$supportTicket->is_internal) {
            $mailable = new SupportTicketCreatedEmail($supportTicket);
            SendEmailJob::dispatch($mailable, $supportTicket->user->email);
        }

        // Send Mail to Staff
        if ($supportTicket->admin && !$supportTicket->department) {
            $mailable = new CreatedEmail($supportTicket);
            SendEmailJob::dispatch($mailable, $supportTicket->admin->email);
        }

        // Send Email to Department/Staff
        if ($supportTicket->department) {
            $supportTicket->department->admins->each(function (Admin $staff) use ($supportTicket) {
                $mailable = new CreatedEmail($supportTicket);
                SendEmailJob::dispatch($mailable, $staff->email);
            });
        }

        $mailable = new CreatedEmail($supportTicket);
        SystemNotificationJob::dispatch($mailable);
    }

    /**
     * Handle the SupportTicket "updated" event.
     */
    public function updated(SupportTicket $supportTicket): void
    {
        $mailable = new UpdatedEmail($supportTicket);
        SystemNotificationJob::dispatch($mailable);
    }

    /**
     * Handle the SupportTicket "deleted" event.
     */
    public function deleted(SupportTicket $supportTicket): void
    {
        if (!$supportTicket->isForceDeleting()) {
            $mailable = new DeletedEmail($supportTicket);
            SystemNotificationJob::dispatch($mailable);
        }
    }

    /**
     * Handle the SupportTicket "restored" event.
     */
    public function restored(SupportTicket $supportTicket): void
    {
        $mailable = new RestoredEmail($supportTicket);
        SystemNotificationJob::dispatch($mailable);
    }

    /**
     * Handle the SupportTicket "force deleted" event.
     */
    public function forceDeleted(SupportTicket $supportTicket): void
    {
        Mail::to(DiligentCreators('notification_email'))
            ->send(new ForceDeletedEmail($supportTicket));
    }
}
