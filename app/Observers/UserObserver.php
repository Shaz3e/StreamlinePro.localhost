<?php

namespace App\Observers;

use App\Jobs\SendEmailJob;
use App\Jobs\SystemNotificationJob;
use App\Mail\System\User\ChangePasswordEmail as UserChangePasswordEmail;
use App\Mail\System\User\CreatedEmail;
use App\Mail\System\User\DeletedEmail;
use App\Mail\System\User\ForceDeletedEmail;
use App\Mail\System\User\InfoChangedEmail as UserInfoChangedEmail;
use App\Mail\System\User\RestoredEmail;
use App\Mail\User\Auth\ChangePasswordEmail;
use App\Mail\User\Auth\InfoChangedEmail;
use App\Mail\User\Auth\RegisterEmail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        $user->name = $user->first_name . ' ' . $user->last_name;
        $user->save();

        if ($user->is_active == 1) {
            $mailable = new RegisterEmail($user, request()->password);
            SendEmailJob::dispatch($mailable, $user->email);
        }

        $mailable = new CreatedEmail($user);
        SystemNotificationJob::dispatch($mailable);
    }

    /**
     * Handle the User "updating" event.
     *
     * @param  mixed $user
     * @return void
     */
    public function updating(User $user): void
    {
        // Concatenate first name and last name to form the full name before saving
        $user->name = $user->first_name . ' ' . $user->last_name;
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        if (!$user->isDirty('first_name') && $user->isDirty('password')) {
            if (request()->filled('password')) {
                $mailable = new ChangePasswordEmail($user, request()->password);
                SendEmailJob::dispatch($mailable, $user->email);

                $mailable = new UserChangePasswordEmail($user, request()->password);
                SystemNotificationJob::dispatch($mailable);
            }
        }

        if ($user->isDirty() && !$user->isDirty('password')) {
            $mailable = new InfoChangedEmail($user);
            SendEmailJob::dispatch($mailable, $user->email);

            $mailable = new UserInfoChangedEmail($user);
            SystemNotificationJob::dispatch($mailable);
        }
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        if (!$user->isForceDeleting()) {
            $mailable = new DeletedEmail($user);
            SystemNotificationJob::dispatch($mailable);
        }
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        $mailable = new RestoredEmail($user);
        SystemNotificationJob::dispatch($mailable);
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        Mail::to(DiligentCreators('notification_email'))
            ->send(new ForceDeletedEmail($user));

        $user->products()->detach();
    }
}
