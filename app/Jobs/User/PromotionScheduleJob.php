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

        // Promotion is_active true/false based on today
        $promotions = Promotion::all();

        foreach ($promotions as $promotion) {
            if ($promotion->start_date->toDateString() >= $today) {
                $promotion->is_active = true;
            } elseif ($promotion->end_date->toDateString() <= $today) {
                $promotion->is_active = false;
            }
            $promotion->save();
        }
    }
}
