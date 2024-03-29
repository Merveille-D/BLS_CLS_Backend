<?php

namespace App\Observers;

use App\Models\Guarantee\ConventionnalHypothecs\ConventionnalHypothec;
use App\Models\User;
use App\Notifications\Guarantee\ConvHypothecInit;
use App\Notifications\Guarantee\ConvHypothecNextStep;
use Carbon\Carbon;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;
use Illuminate\Support\Facades\Log;

class ConvHypothecObserver implements ShouldHandleEventsAfterCommit
{
    /**
     * Handle the ConventionnalHypothec "created" event.
     */
    public function created(ConventionnalHypothec $conventionnalHypothec): void
    {
        $user = User::find(1);

        $user->notify((new ConvHypothecInit($conventionnalHypothec))/* ->delay(Carbon::now()->addMinutes(2)) */);
    }

    /**
     * Handle the ConventionnalHypothec "updated" event.
     */
    public function updated(ConventionnalHypothec $conventionnalHypothec): void
    {
        $user = User::find(1);

        $user->notify((new ConvHypothecNextStep($conventionnalHypothec))/* ->delay(Carbon::now()->addMinutes(2)) */);
    }

    /**
     * Handle the ConventionnalHypothec "deleted" event.
     */
    public function deleted(ConventionnalHypothec $conventionnalHypothec): void
    {
        //
    }

    /**
     * Handle the ConventionnalHypothec "restored" event.
     */
    public function restored(ConventionnalHypothec $conventionnalHypothec): void
    {
        //
    }

    /**
     * Handle the ConventionnalHypothec "force deleted" event.
     */
    public function forceDeleted(ConventionnalHypothec $conventionnalHypothec): void
    {
        //
    }
}
