<?php

namespace App\Observers;

use App\Models\Promotion;
use Illuminate\Support\Facades\File;

class PromotionObserver extends BaseObserver
{
    /**
     * Handle the Promotion "created" event.
     */
    public function created(Promotion $promotion): void
    {
        //
    }

    /**
     * Handle the Promotion "updated" event.
     */
    public function updated(Promotion $promotion): void
    {
        //
    }

    /**
     * Handle the Promotion "deleted" event.
     */
    public function deleted(Promotion $promotion): void
    {
        //
    }

    /**
     * Handle the Promotion "restored" event.
     */
    public function restored(Promotion $promotion): void
    {
        //
    }

    /**
     * Handle the Promotion "force deleted" event.
     */
    public function forceDeleted(Promotion $promotion): void
    {
        // Send email to system

        // Delete promotion image
        if (File::exists(public_path($promotion->image))) {
            File::delete(public_path($promotion->image));
        }
    }
}
