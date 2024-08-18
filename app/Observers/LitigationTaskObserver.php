<?php

namespace App\Observers;

use App\Concerns\Traits\Alert\AddAlertTrait;
use App\Models\Alert\Alert;
use App\Models\Litigation\LitigationTask;
use Carbon\Carbon;

class LitigationTaskObserver
{
    use AddAlertTrait;
    /**
     * Handle the LitigationTask "created" event.
     */
    public function created(LitigationTask $litigationTask): void
    {
        //
    }

    /**
     * Handle the LitigationTask "updated" event.
     */
    public function updated(LitigationTask $litigationTask): void
    {
        if ($litigationTask->status == true && $litigationTask->taskable?->next_task) {
            $max_deadline = $litigationTask->taskable?->next_task?->max_deadline;
            $dates = $this->getMilestoneDates(Carbon::parse($max_deadline));

            foreach ($dates as $key => $date) {
                $this->new_alert(
                    $litigationTask,
                    'RAPPEL | '. $litigationTask->taskable?->name ?? '',
                    __('litigation.'.$litigationTask->taskable?->next_task?->title ?? ''),
                    'litigation',
                    $date,
                    Alert::STATUS[$key] ?? 'urgent',
                    $max_deadline,
                );
            }
        }
    }

    /**
     * Handle the LitigationTask "deleted" event.
     */
    public function deleted(LitigationTask $litigationTask): void
    {
        //
    }

    /**
     * Handle the LitigationTask "restored" event.
     */
    public function restored(LitigationTask $litigationTask): void
    {
        //
    }

    /**
     * Handle the LitigationTask "force deleted" event.
     */
    public function forceDeleted(LitigationTask $litigationTask): void
    {
        //
    }
}
