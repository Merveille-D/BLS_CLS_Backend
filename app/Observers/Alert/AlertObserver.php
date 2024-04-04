<?php

namespace App\Observers\Alert;

use App\Models\Alert\Alert;
use App\Models\User;
use App\Notifications\AlertNotification;

class AlertObserver
{
    /**
     * Handle the Alert "created" event.
     */
    public function created(Alert $alert): void
    {
        $users = User::all();

        foreach ($users as $key => $user) {
            $user->notify((new AlertNotification($alert))->delay($alert->trigger_at));
        }
    }

    /**
     * Handle the Alert "updated" event.
     */
    public function updated(Alert $alert): void
    {
        //
    }

    /**
     * Handle the Alert "deleted" event.
     */
    public function deleted(Alert $alert): void
    {
        //
    }

    /**
     * Handle the Alert "restored" event.
     */
    public function restored(Alert $alert): void
    {
        //
    }

    /**
     * Handle the Alert "force deleted" event.
     */
    public function forceDeleted(Alert $alert): void
    {
        //
    }
}
