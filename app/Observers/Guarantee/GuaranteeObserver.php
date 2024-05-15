<?php

namespace App\Observers\Guarantee;

use App\Models\Guarantee\Guarantee;

class GuaranteeObserver
{
    /**
     * Handle the Guarantee "created" event.
     */
    public function created(Guarantee $guarantee): void
    {
        //
    }

    /**
     * Handle the Guarantee "updated" event.
     */
    public function updated(Guarantee $guarantee): void
    {
        //
    }

    /**
     * Handle the Guarantee "deleted" event.
     */
    public function deleted(Guarantee $guarantee): void
    {
        //
    }

    /**
     * Handle the Guarantee "restored" event.
     */
    public function restored(Guarantee $guarantee): void
    {
        //
    }

    /**
     * Handle the Guarantee "force deleted" event.
     */
    public function forceDeleted(Guarantee $guarantee): void
    {
        //
    }
}
