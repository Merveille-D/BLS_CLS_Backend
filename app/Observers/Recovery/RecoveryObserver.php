<?php

namespace App\Observers\Recovery;

use App\Concerns\Traits\Alert\AddAlertTrait;
use App\Concerns\Traits\Recovery\RecoveryNotificationTrait;
use App\Models\Alert\Alert;
use App\Models\Recovery\Recovery;
use Carbon\Carbon;

class RecoveryObserver
{
    use RecoveryNotificationTrait, AddAlertTrait;
    /**
     * Handle the Recovery "created" event.
     */
    public function created(Recovery $recovery): void
    {
        if (!$recovery->has_guarantee) {
            $data = $this->nextStepBasedOnState($recovery);

            $this->new_alert($recovery, 'RAPPEL | Recouvrement', $data['message'], 'recovery', Carbon::now()->addDays(3), 'warning');
        }
    }

    /**
     * Handle the Recovery "updated" event.
     */
    public function updated(Recovery $recovery): void
    {
        if (!$recovery->has_guarantee) {
            $data = $this->nextStepBasedOnState($recovery);

            $this->new_alert($recovery, 'RAPPEL | Recouvrement', $data['message'], 'recovery', Carbon::now()->addDays(3), 'warning');
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
