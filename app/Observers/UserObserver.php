<?php

namespace App\Observers;

use App\Mail\Admin\User\PasswordReset;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        //
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        if ($user->isDirty('password')) {
            $mailData = [
                'url' => config('app.url'),
                'name' => $user->name,
                'email' => $user->email,
                'password' => request()->password,
            ];

            Mail::to($mailData['email'])->send(new PasswordReset($mailData));
        }
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        //
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}
