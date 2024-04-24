<?php

namespace App\Observers;

use App\Models\Contract\Task;

class TaskContractObserver
{
    /**
     * Handle the Task "created" event.
     */
    public function created(Task $task): void
    {
        if(checkDealine($task->deadline)) {
            $task->alerts()->save(triggerAlert("RAPPEL | CONTRAT", $task->libelle));
        }
    }

    /**
     * Handle the Task "updated" event.
     */
    public function updated(Task $task): void
    {
        //
    }

    /**
     * Handle the Task "deleted" event.
     */
    public function deleted(Task $task): void
    {
        //
    }

    /**
     * Handle the Task "restored" event.
     */
    public function restored(Task $task): void
    {
        //
    }

    /**
     * Handle the Task "force deleted" event.
     */
    public function forceDeleted(Task $task): void
    {
        //
    }
}
