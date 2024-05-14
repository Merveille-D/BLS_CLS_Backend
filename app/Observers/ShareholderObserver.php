<?php

namespace App\Observers;

use App\Models\Shareholder\Shareholder;

class ShareholderObserver
{
    /**
     * Handle the Shareholder "created" event.
     */
    public function created(Shareholder $shareholder): void
    {
        //
    }

    /**
     * Handle the Shareholder "updated" event.
     */
    public function updated(Shareholder $shareholder): void
    {
        //
    }

    /**
     * Handle the Shareholder "deleted" event.
     */
    public function deleted(Shareholder $shareholder): void
    {
        //
    }

    /**
     * Handle the Shareholder "restored" event.
     */
    public function restored(Shareholder $shareholder): void
    {
        //
    }

    /**
     * Handle the Shareholder "force deleted" event.
     */
    public function forceDeleted(Shareholder $shareholder): void
    {
        //
    }
}
