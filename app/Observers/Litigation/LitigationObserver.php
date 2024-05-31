<?php

namespace App\Observers\Litigation;

use App\Models\Litigation\Litigation;

class LitigationObserver
{
    /**
     * Handle the Litigation "created" event.
     */
    public function created(Litigation $litigation): void
    {
        //
    }

    /**
     * Handle the Litigation "updated" event.
     */
    public function updated(Litigation $litigation): void
    {
        //
    }

    /**
     * Handle the Litigation "deleted" event.
     */
    public function deleted(Litigation $litigation): void
    {
        //
    }

    /**
     * Handle the Litigation "restored" event.
     */
    public function restored(Litigation $litigation): void
    {
        //
    }

    /**
     * Handle the Litigation "force deleted" event.
     */
    public function forceDeleted(Litigation $litigation): void
    {
        //
    }
}
