<?php

namespace App\Observers;

use App\Mail\SupportTicket\SupportTicketCreatedEmail;
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
        // Send Mail to User if its not internal ticket
        if ($supportTicket->is_internal == 0 && $supportTicket->user) {
            Mail::to($supportTicket->user->email)
                ->queue(new SupportTicketCreatedEmail($supportTicket, $supportTicket->user));
        }

        // Send Mail to Staff
        if ($supportTicket->admin && !$supportTicket->department) {
            Mail::to($supportTicket->admin->email)
                ->queue(new SupportTicketCreatedEmail($supportTicket, $supportTicket->admin));
        }

        // Send Email to Department/Staff
        if ($supportTicket->department) {
            $supportTicket->department->admins->each(function (Admin $staff) use ($supportTicket) {
                Mail::to($staff->email)
                    ->queue(new SupportTicketCreatedEmail($supportTicket, $staff)); // Pass the admin as the recipient
            });
        }
    }

    /**
     * Handle the SupportTicket "updated" event.
     */
    public function updated(SupportTicket $supportTicket): void
    {
        //
    }

    /**
     * Handle the SupportTicket "deleted" event.
     */
    public function deleted(SupportTicket $supportTicket): void
    {
        //
    }

    /**
     * Handle the SupportTicket "restored" event.
     */
    public function restored(SupportTicket $supportTicket): void
    {
        //
    }

    /**
     * Handle the SupportTicket "force deleted" event.
     */
    public function forceDeleted(SupportTicket $supportTicket): void
    {
        //
    }
}
