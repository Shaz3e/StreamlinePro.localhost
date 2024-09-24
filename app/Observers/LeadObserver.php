<?php

namespace App\Observers;

use App\Models\Lead;

class LeadObserver extends BaseObserver
{
    /**
     * Handle the Lead "created" event.
     */
    public function created(Lead $lead): void
    {
        // $user = auth()->user();
        // logger()->info("Lead Created: " . $lead);
        $this->bell->notifySystem(
            'New Lead Received',
            'You have new lead',
            $lead->id,
            'leads',
            'show',
        );
    }

    /**
     * Handle the Lead "updated" event.
     */
    public function updated(Lead $lead): void
    {
        // $user = auth()->user();

        if ($lead->isDirty('created_by')) {
            // Bell notification
        }
        if ($lead->isDirty('updated_by')) {
            // Bell notification
        }
        if ($lead->isDirty('assigned_to')) {
            // Bell notification
        }
        if ($lead->isDirty('assigned_by')) {
            // Bell notification
        }
    }

    /**
     * Handle the Lead "deleted" event.
     */
    public function deleted(Lead $lead): void
    {
        //
    }

    /**
     * Handle the Lead "restored" event.
     */
    public function restored(Lead $lead): void
    {
        //
    }

    /**
     * Handle the Lead "force deleted" event.
     */
    public function forceDeleted(Lead $lead): void
    {
        //
    }
}
