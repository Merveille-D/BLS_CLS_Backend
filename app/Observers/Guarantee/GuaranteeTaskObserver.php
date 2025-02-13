<?php

namespace App\Observers\Guarantee;

use App\Concerns\Traits\Alert\AddAlertTrait;
use App\Models\Alert\Alert;
use App\Models\Guarantee\GuaranteeTask;
use Carbon\Carbon;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;

class GuaranteeTaskObserver implements ShouldHandleEventsAfterCommit
{
    use AddAlertTrait;

    /**
     * Handle the GuaranteeTask "created" event.
     */
    public function created(GuaranteeTask $guaranteeTask): void
    {
        // if ($guaranteeTask->code == 'created') {
        //     dd($guaranteeTask->taskable?->next_task?->title);
        //     $this->newAlert($guaranteeTask, 'RAPPEL | '. $guaranteeTask->taskable?->next_task?->title ?? 'Tâche', $data['message'] ?? 'TEST', $guaranteeTask->taskable?->security ?? 'guarantee', Carbon::now()->addDays(3), Alert::STATUS[2] ?? 'urgent');
        // }
    }

    /**
     * Handle the GuaranteeTask "updated" event.
     */
    public function updated(GuaranteeTask $guaranteeTask): void
    {
        if ($guaranteeTask->status == true && $guaranteeTask->taskable?->next_task) {
            $max_deadline = $guaranteeTask->taskable?->next_task?->max_deadline;
            // $dates = $this->getMilestoneDates(Carbon::parse($max_deadline));

            // foreach ($dates as $key => $date) {
            $this->newAlert(
                $guaranteeTask,
                'RAPPEL | ' . $guaranteeTask->taskable?->name ?? '',
                __('security.' . $guaranteeTask->taskable?->next_task?->title ?? ''),
                $guaranteeTask->taskable?->security ?? 'guarantee',
                /* $date, */ now(),
                /* Alert::STATUS[$key] ??  */ 'urgent',
                $max_deadline,
            );
            // }
        }
    }

    /**
     * Handle the GuaranteeTask "deleted" event.
     */
    public function deleted(GuaranteeTask $guaranteeTask): void
    {
        //
    }

    /**
     * Handle the GuaranteeTask "restored" event.
     */
    public function restored(GuaranteeTask $guaranteeTask): void
    {
        //
    }

    /**
     * Handle the GuaranteeTask "force deleted" event.
     */
    public function forceDeleted(GuaranteeTask $guaranteeTask): void
    {
        //
    }
}
