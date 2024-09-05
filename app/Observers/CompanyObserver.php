<?php

namespace App\Observers;

use App\Jobs\SystemNotificationJob;
use App\Mail\System\Company\CreatedEmail;
use App\Mail\System\Company\DeletedEmail;
use App\Mail\System\Company\ForceDeletedEmail;
use App\Mail\System\Company\RestoredEmail;
use App\Mail\System\Company\UpdatedEmail;
use App\Models\Company;
use Illuminate\Support\Facades\Mail;

class CompanyObserver
{
    /**
     * Handle the Company "created" event.
     */
    public function created(Company $company): void
    {
        $mailable = new CreatedEmail($company);
        SystemNotificationJob::dispatch($mailable);
    }

    /**
     * Handle the Company "updated" event.
     */
    public function updated(Company $company): void
    {
        // get all users in this company
        $users = $company->users;

        if ($company->is_active == false) {
            foreach ($users as $user) {
                $user->is_active = false;
                $user->save();
            }
        }
        if ($company->is_active == true) {
            foreach ($users as $user) {
                $user->is_active = true;
                $user->save();
            }
        }

        $mailable = new UpdatedEmail($company);
        SystemNotificationJob::dispatch($mailable);
    }

    /**
     * Handle the Company "deleted" event.
     */
    public function deleted(Company $company): void
    {
        if (!$company->isForceDeleting()) {
            $mailable = new DeletedEmail($company);
            SystemNotificationJob::dispatch($mailable);
        }
    }

    /**
     * Handle the Company "restored" event.
     */
    public function restored(Company $company): void
    {
        $mailable = new RestoredEmail($company);
        SystemNotificationJob::dispatch($mailable);
    }

    /**
     * Handle the Company "force deleted" event.
     */
    public function forceDeleted(Company $company): void
    {
        Mail::to(DiligentCreators('notification_email'))
            ->send(new ForceDeletedEmail($company));
    }
}
