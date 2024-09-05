<?php

namespace App\Observers;

use App\Jobs\SendEmailJob;
use App\Jobs\SystemNotificationJob;
use App\Mail\System\SupportTicket\ReplyCreatedEmail;
use App\Mail\User\SupportTicket\ReplyCreatedEmail as SupportTicketReplyCreatedEmail;
use App\Models\SupportTicket;
use App\Models\SupportTicketReply;

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
            $mailable = new SupportTicketReplyCreatedEmail($supportTicketReply);
            SendEmailJob::dispatch($mailable, $supportTicket->user->email);
        }

        $mailable = new ReplyCreatedEmail($supportTicketReply);
        SystemNotificationJob::dispatch($mailable);
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
