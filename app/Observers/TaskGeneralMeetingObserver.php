<?php

namespace App\Observers;

use App\Models\Gourvernance\GeneralMeeting\TaskGeneralMeeting;

class TaskGeneralMeetingObserver
{
    /**
     * Handle the TaskGeneralMeeting "created" event.
     */
    public function created(TaskGeneralMeeting $taskGeneralMeeting): void
    {
        if(checkDealine($taskGeneralMeeting->deadline)) {
            $taskGeneralMeeting->alerts()->save(triggerAlert("RAPPEL | ASSEMBLEE GENERALE", $taskGeneralMeeting->libelle));
        }
    }

    /**
     * Handle the TaskGeneralMeeting "updated" event.
     */
    public function updated(TaskGeneralMeeting $taskGeneralMeeting): void
    {
        //
    }

    /**
     * Handle the TaskGeneralMeeting "deleted" event.
     */
    public function deleted(TaskGeneralMeeting $taskGeneralMeeting): void
    {
        //
    }

    /**
     * Handle the TaskGeneralMeeting "restored" event.
     */
    public function restored(TaskGeneralMeeting $taskGeneralMeeting): void
    {
        //
    }

    /**
     * Handle the TaskGeneralMeeting "force deleted" event.
     */
    public function forceDeleted(TaskGeneralMeeting $taskGeneralMeeting): void
    {
        //
    }
}
