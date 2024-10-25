<?php

namespace App\Observers;

use App\Concerns\Traits\Alert\AddAlertTrait;
use App\Concerns\Traits\Guarantee\ConvHypothecNotificationTrait;
use App\Models\Alert\Alert;
use App\Models\Guarantee\ConvHypothec;
use Carbon\Carbon;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;

class ConvHypothecObserver implements ShouldHandleEventsAfterCommit
{
    use AddAlertTrait, ConvHypothecNotificationTrait;

    /**
     * Handle the ConventionnalHypothec "created" event.
     */
    public function created(ConvHypothec $convHypo): void
    {
        $data = $this->nextStepBasedOnState($convHypo->state);

        $this->newAlert($convHypo, 'RAPPEL | ' . $convHypo->name ?? 'Hypothèque conventionnelle', $data['message'], 'conventionnal_hypothec', Carbon::now()->addDays(3), Alert::STATUS[2] ?? 'urgent');
    }

    /**
     * Handle the ConventionnalHypothec "updated" event.
     */
    public function updated(ConvHypothec $convHypo): void
    {
        $data = $this->nextStepBasedOnState($convHypo->state);

        $this->newAlert($convHypo, 'RAPPEL | ' . $convHypo->name ?? 'Hypothèque conventionnelle', $data['message'], 'conventionnal_hypothec', Carbon::now()->addDays(3), Alert::STATUS[2] ?? 'urgent');
    }

    /**
     * Handle the ConventionnalHypothec "deleted" event.
     */
    public function deleted(ConvHypothec $conventionnalHypothec): void
    {
        //
    }

    /**
     * Handle the ConventionnalHypothec "restored" event.
     */
    public function restored(ConvHypothec $conventionnalHypothec): void
    {
        //
    }

    /**
     * Handle the ConventionnalHypothec "force deleted" event.
     */
    public function forceDeleted(ConvHypothec $conventionnalHypothec): void
    {
        //
    }
}
