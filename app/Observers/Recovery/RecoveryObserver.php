<?php

namespace App\Observers\Recovery;

use App\Concerns\Traits\Recovery\RecoveryNotificationTrait;
use App\Models\Alert\Alert;
use App\Models\Recovery\Recovery;
use Carbon\Carbon;

class RecoveryObserver
{
    use RecoveryNotificationTrait;
    /**
     * Handle the Recovery "created" event.
     */
    public function created(Recovery $recovery): void
    {
        if (!$recovery->has_guarantee) {
            $data = $this->nextStepBasedOnState($recovery);
            $alert = new Alert();
            $alert->title = 'RAPPEL | Recouvrement'; //$data['subject'];
            $alert->type = 'recovery';
            $alert->priority = 'high';
            $alert->message = $data['message'];
            // $alert->trigger_at = Carbon::now()->addDays(3);
            $alert->trigger_at = Carbon::now()->addMinutes(5);
            $recovery->alerts()->save($alert);
        }
    }

    /**
     * Handle the Recovery "updated" event.
     */
    public function updated(Recovery $recovery): void
    {
        if (!$recovery->has_guarantee) {
            $data = $this->nextStepBasedOnState($recovery);
            $alert = new Alert();
            $alert->title = 'RAPPEL | Recouvrement'; //$data['subject'];
            $alert->type = 'recovery';
            $alert->priority = 'high';
            $alert->message = $data['message'];
            // $alert->trigger_at = Carbon::now()->addDays(3);
            $alert->trigger_at = Carbon::now()->addMinutes(5);
            $recovery->alerts()->save($alert);
        }
    }

    /**
     * Handle the Recovery "deleted" event.
     */
    public function deleted(Recovery $recovery): void
    {
        //
    }

    /**
     * Handle the Recovery "restored" event.
     */
    public function restored(Recovery $recovery): void
    {
        //
    }

    /**
     * Handle the Recovery "force deleted" event.
     */
    public function forceDeleted(Recovery $recovery): void
    {
        //
    }
}
