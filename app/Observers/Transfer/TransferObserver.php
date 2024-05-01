<?php

namespace App\Observers\Transfer;

use App\Concerns\Traits\Alert\AddAlertTrait;
use App\Models\Transfer\Transfer;

class TransferObserver
{
    use AddAlertTrait;
    /**
     * Handle the Transfer "created" event.
     */
    public function created(Transfer $transfer): void
    {
        $dates = $this->getMilestoneDates($transfer->deadline);
        foreach ($dates as $date) {
            $this->new_alert($transfer, $transfer->title, $transfer->description, 'transfer', $date, 'warning');
        }

        // $this->new_alert($transfer, $transfer->title, $transfer->description, 'transfer', $transfer->deadline, 'warning');
    }

    /**
     * Handle the Transfer "updated" event.
     */
    public function updated(Transfer $transfer): void
    {
        dd('updated ');
    }

    /**
     * Handle the Transfer "deleted" event.
     */
    public function deleted(Transfer $transfer): void
    {
        //
    }

    /**
     * Handle the Transfer "restored" event.
     */
    public function restored(Transfer $transfer): void
    {
        //
    }

    /**
     * Handle the Transfer "force deleted" event.
     */
    public function forceDeleted(Transfer $transfer): void
    {
        //
    }
}
