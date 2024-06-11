<?php

namespace App\Observers;

use App\Models\Company;
use Illuminate\Support\Facades\Log;

class CompanyObserver
{
    /**
     * Handle the Company "created" event.
     */
    public function created(Company $company): void
    {
        //
    }

    /**
     * Handle the Company "updated" event.
     */
    public function updated(Company $company): void
    {
        // get all users in this company
        $users = $company->users;
        
        if($company->is_active == false){
            foreach($users as $user){
                $user->is_active = false;
                $user->save();
            }
        }
        if($company->is_active == true){
            foreach($users as $user){
                $user->is_active = true;
                $user->save();
            }
        }
    }

    /**
     * Handle the Company "deleted" event.
     */
    public function deleted(Company $company): void
    {
        //
    }

    /**
     * Handle the Company "restored" event.
     */
    public function restored(Company $company): void
    {
        //
    }

    /**
     * Handle the Company "force deleted" event.
     */
    public function forceDeleted(Company $company): void
    {
        //
    }
}
