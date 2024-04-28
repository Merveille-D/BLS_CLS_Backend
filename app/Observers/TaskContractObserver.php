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

    }

    /**
     * Handle the Task "updated" event.
     */
    public function updated(Task $task): void
    {
        if($task->status) {
            $alertsExist = $task->alerts()->delete();
        }
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
