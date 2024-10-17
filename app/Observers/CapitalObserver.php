<?php

namespace App\Observers;

use App\Models\Shareholder\Capital;
use App\Models\Shareholder\Shareholder;

class CapitalObserver
{
    /**
     * Handle the Capital "created" event.
     */
    public function created(Capital $capital): void
    {
        $shareholders = Shareholder::all();
        $capital = Capital::get()->last();
        $total_actions = $capital->amount / $capital->par_value;

        foreach ($shareholders as $shareholder) {
            $percentage = ($shareholder->actions_number / $total_actions) * 100;
            $shareholder->update(['percentage' => $percentage]);
        }

    }

    /**
     * Handle the Capital "updated" event.
     */
    public function updated(Capital $capital): void
    {
        $shareholders = Shareholder::all();
        $capital = Capital::get()->last();
        $total_actions = $capital->amount / $capital->par_value;

        foreach ($shareholders as $shareholder) {
            $percentage = ($shareholder->actions_number / $total_actions) * 100;
            $shareholder->update(['percentage' => $percentage]);
        }
    }

    /**
     * Handle the Capital "deleted" event.
     */
    public function deleted(Capital $capital): void
    {
        //
    }

    /**
     * Handle the Capital "restored" event.
     */
    public function restored(Capital $capital): void
    {
        //
    }

    /**
     * Handle the Capital "force deleted" event.
     */
    public function forceDeleted(Capital $capital): void
    {
        //
    }
}
