<?php

namespace App\Jobs\User;

use App\Models\Promotion;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PromotionScheduleJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $today = Carbon::now()->toDateString();

        // Retrieve all promotions
        $promotions = Promotion::all();

        foreach ($promotions as $promotion) {
            // Activate promotions where start_date is before or equal to today, and end_date is after or equal to today
            if ($promotion->start_date->toDateString() <= $today && $promotion->end_date->toDateString() >= $today) {
                $promotion->is_active = true;
            }
            // Deactivate promotions that have ended or haven't started
            else {
                $promotion->is_active = false;
            }

            // Save changes to the promotion
            $promotion->save();
        }
    }
}
