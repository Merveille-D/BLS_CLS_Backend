<?php

namespace App\Observers;

use App\Concerns\Traits\Guarantee\ConvHypothecNotificationTrait;
use App\Models\Alert\Alert;
use App\Models\Guarantee\ConventionnalHypothecs\ConventionnalHypothec;
use App\Models\Guarantee\ConvHypothec;
use App\Models\User;
use App\Notifications\Guarantee\ConvHypothecInit;
use App\Notifications\Guarantee\ConvHypothecNextStep;
use Carbon\Carbon;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;
use Illuminate\Support\Facades\Log;

class ConvHypothecObserver implements ShouldHandleEventsAfterCommit
{
    use ConvHypothecNotificationTrait;

    /**
     * Handle the ConventionnalHypothec "created" event.
     */
    public function created(ConvHypothec $convHypo): void
    {
        $data = $this->nextStepBasedOnState($convHypo->state);

        $alert = new Alert();
        $alert->title = 'RAPPEL | Hypothèque conventionnelle'; //$data['subject'];
        $alert->type = 'hypothec';
        $alert->message = $data['message'];
        // $alert->trigger_at = Carbon::now()->addDays(3);
        $alert->trigger_at = Carbon::now()->addMinutes(5);
        $convHypo->alerts()->save($alert);
    }

    /**
     * Handle the ConventionnalHypothec "updated" event.
     */
    public function updated(ConvHypothec $convHypo): void
    {
        $data = $this->nextStepBasedOnState($convHypo->state);

        $alert = new Alert();
        $alert->title = 'RAPPEL | Hypothèque conventionnelle'; //$data['subject'];
        $alert->type = 'hypothec';
        $alert->message = $data['message'];
        $alert->trigger_at = Carbon::now()->addMinutes(5);
        $convHypo->alerts()->save($alert);
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
