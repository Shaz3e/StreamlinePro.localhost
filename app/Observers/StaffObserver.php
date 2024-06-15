<?php

namespace App\Observers;

use App\Mail\Staff\CreateStaffEmail;
use App\Mail\Staff\PasswordResetStaff;
use App\Models\Admin;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class StaffObserver
{
    /**
     * Handle the Admin "created" event.
     */
    public function created(Admin $admin): void
    {
        Mail::to($admin->email)->send(new CreateStaffEmail($admin));
    }

    /**
     * Handle the Admin "updated" event.
     */
    public function updated(Admin $admin): void
    {
        if (request()->filled('password')) {
            // Check token
            $tokenExists = DB::table('password_reset_tokens')
                ->where('email', $admin->email)
                ->exists();

            if (!$tokenExists) {
                // Delete the token from database
                DB::table('password_reset_tokens')
                    ->where('email', $admin->email)
                    ->delete();
            }

            $token = Str::random(60);

            Mail::to($admin->email)
                ->send(new PasswordResetStaff($admin, $token));
        }
    }

    /**
     * Handle the Admin "deleted" event.
     */
    public function deleted(Admin $admin): void
    {
        //
    }

    /**
     * Handle the Admin "restored" event.
     */
    public function restored(Admin $admin): void
    {
        //
    }

    /**
     * Handle the Admin "force deleted" event.
     */
    public function forceDeleted(Admin $admin): void
    {
        //
    }
}
