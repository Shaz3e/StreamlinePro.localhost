<?php

namespace App\Observers;

use App\Mail\SupportTicket\SupportTicketReplyCreatedEmail;
use App\Models\SupportTicket;
use App\Models\SupportTicketReply;
use Illuminate\Support\Facades\Mail;

class SupportTicketReplyObserver
{
    /**
     * Handle the SupportTicketReply "created" event.
     */
    public function created(SupportTicketReply $supportTicketReply): void
    {
        $supportTicket = SupportTicket::where('id', $supportTicketReply->support_ticket_id)->first();

        // Send Mail to User if its not internal ticket
        if ($supportTicket->is_internal == 0 && $supportTicket->user) {
            Mail::to($supportTicket->user->email)
                ->queue(new SupportTicketReplyCreatedEmail($supportTicketReply, $supportTicketReply->client));
        }
    }

    /**
     * Handle the SupportTicketReply "updated" event.
     */
    public function updated(SupportTicketReply $supportTicketReply): void
    {
        //
    }

    /**
     * Handle the SupportTicketReply "deleted" event.
     */
    public function deleted(SupportTicketReply $supportTicketReply): void
    {
        //
    }

    /**
     * Handle the SupportTicketReply "restored" event.
     */
    public function restored(SupportTicketReply $supportTicketReply): void
    {
        //
    }

    /**
     * Handle the SupportTicketReply "force deleted" event.
     */
    public function forceDeleted(SupportTicketReply $supportTicketReply): void
    {
        //
    }
}
