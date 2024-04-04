<?php

namespace App\Observers;

use App\Concerns\Traits\Guarantee\ConvHypothecNotificationTrait;
use App\Models\Alert\Alert;
use App\Models\Guarantee\ConventionnalHypothecs\ConventionnalHypothec;
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
    public function created(ConventionnalHypothec $convHypo): void
    {
        $alert = new Alert();
        $alert->title = 'test title';
        $alert->type = 'hypothec';
        $alert->message = 'message content';
        $alert->trigger_at = Carbon::now()->addMinutes(5); //TODO : correct delay

        $convHypo->alerts()->save($alert);
        // $user = User::find(1);

        // $user->notify((new ConvHypothecInit($conventionnalHypothec))/* ->delay(Carbon::now()->addMinutes(2)) */);
    }

    /**
     * Handle the ConventionnalHypothec "updated" event.
     */
    public function updated(ConventionnalHypothec $convHypo): void
    {
        $data = $this->nextStepBasedOnState($convHypo->state);

        $alert = new Alert();
        $alert->title = $data['subject'];
        $alert->type = 'hypothec';
        $alert->message = $data['message'];
        $alert->trigger_at = Carbon::now()->addMinutes(5);
        $convHypo->alerts()->save($alert);
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
