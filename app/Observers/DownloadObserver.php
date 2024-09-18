<?php

namespace App\Observers;

use App\Models\Download;

class DownloadObserver extends BaseObserver
{
    /**
     * Handle the Download "created" event.
     */
    public function created(Download $download): void
    {
        //
    }

    /**
     * Handle the Download "updated" event.
     */
    public function updated(Download $download): void
    {
        if ($download->is_active == true) {
            foreach ($download->users as $user) {
                $this->bell->notifyUser(
                    $user->id,
                    'New download available',
                    $download->title,
                    $download->id,
                    'downloads',
                    'show'
                );
            }
        }
    }

    /**
     * Handle the Download "deleted" event.
     */
    public function deleted(Download $download): void
    {
        //
    }

    /**
     * Handle the Download "restored" event.
     */
    public function restored(Download $download): void
    {
        //
    }

    /**
     * Handle the Download "force deleted" event.
     */
    public function forceDeleted(Download $download): void
    {
        //
    }
}
