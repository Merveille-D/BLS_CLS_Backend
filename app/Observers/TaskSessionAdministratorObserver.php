<?php

namespace App\Observers;

use App\Models\Gourvernance\BoardDirectors\Sessions\TaskSessionAdministrator;

class TaskSessionAdministratorObserver
{
    /**
     * Handle the TaskSessionAdministrator "created" event.
     */
    public function created(TaskSessionAdministrator $taskSessionAdministrator): void
    {
        if(checkDealine($taskSessionAdministrator->deadline)) {
            $taskSessionAdministrator->alerts()->save(triggerAlert("RAPPEL | SESSION ADMINISTRATEUR", $taskSessionAdministrator->libelle));
        }
    }

    /**
     * Handle the TaskSessionAdministrator "updated" event.
     */
    public function updated(TaskSessionAdministrator $taskSessionAdministrator): void
    {
        //
    }

    /**
     * Handle the TaskSessionAdministrator "deleted" event.
     */
    public function deleted(TaskSessionAdministrator $taskSessionAdministrator): void
    {
        //
    }

    /**
     * Handle the TaskSessionAdministrator "restored" event.
     */
    public function restored(TaskSessionAdministrator $taskSessionAdministrator): void
    {
        //
    }

    /**
     * Handle the TaskSessionAdministrator "force deleted" event.
     */
    public function forceDeleted(TaskSessionAdministrator $taskSessionAdministrator): void
    {
        //
    }
}