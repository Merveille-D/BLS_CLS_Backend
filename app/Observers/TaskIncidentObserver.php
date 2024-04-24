<?php

namespace App\Observers;

use App\Models\Incident\TaskIncident;

class TaskIncidentObserver
{
    /**
     * Handle the TaskIncident "created" event.
     */
    public function created(TaskIncident $taskIncident): void
    {

    }

    /**
     * Handle the TaskIncident "updated" event.
     */
    public function updated(TaskIncident $taskIncident): void
    {
        $next_task = $taskIncident->where('incident_id', $taskIncident->incident_id)->where('status', false)->first();
        $next_task->alerts()->save(triggerAlert("RAPPEL | INCIDENT", $next_task->title));
    }

    /**
     * Handle the TaskIncident "deleted" event.
     */
    public function deleted(TaskIncident $taskIncident): void
    {
        //
    }

    /**
     * Handle the TaskIncident "restored" event.
     */
    public function restored(TaskIncident $taskIncident): void
    {
        //
    }

    /**
     * Handle the TaskIncident "force deleted" event.
     */
    public function forceDeleted(TaskIncident $taskIncident): void
    {
        //
    }
}
