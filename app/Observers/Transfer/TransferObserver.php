<?php

namespace App\Observers\Transfer;

use App\Concerns\Traits\Alert\AddAlertTrait;
use App\Models\Alert\Alert;
use App\Models\Transfer\Transfer;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;

class TransferObserver implements ShouldHandleEventsAfterCommit
{
    use AddAlertTrait;
    /**
     * Handle the Transfer "created" event.
     */
    public function created(Transfer $transfer): void
    {
        // $dates = $this->getMilestoneDates($transfer->deadline);
        // foreach ($dates as $key => $date) {
        //     $this->new_alert($transfer, $transfer->title, $transfer->description, 'transfer', $date, Alert::STATUS[$key]);
        // }

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
