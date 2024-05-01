<?php

namespace App\Observers;

use App\Concerns\Traits\Alert\AddAlertTrait;
use App\Concerns\Traits\Guarantee\ConvHypothecNotificationTrait;
use App\Concerns\Traits\Transfer\AddTransferTrait;
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
    use ConvHypothecNotificationTrait, AddAlertTrait, AddTransferTrait;

    /**
     * Handle the ConventionnalHypothec "created" event.
     */
    public function created(ConvHypothec $convHypo): void
    {
        $data = $this->nextStepBasedOnState($convHypo->state);

        $this->new_alert($convHypo, 'RAPPEL | Hypothèque conventionnelle', $data['message'], 'conventionnal_hypothec', Carbon::now()->addDays(3), 'warning');

        $this->add_transfer($convHypo, 'RAPPEL | Hypothèque conventionnelle', Carbon::now()->addDays(3), $data['message'], User::all()->pluck('id')->toArray());
    }

    /**
     * Handle the ConventionnalHypothec "updated" event.
     */
    public function updated(ConvHypothec $convHypo): void
    {
        $data = $this->nextStepBasedOnState($convHypo->state);

        $this->new_alert($convHypo, 'RAPPEL | Hypothèque conventionnelle', $data['message'], 'conventionnal_hypothec', Carbon::now()->addDays(3), 'warning');

        // $this->update_transfer($convHypo, User::all()->pluck('id')->toArray());

        // dd('updated'    );
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
