<?php

namespace App\Observers;

use App\Models\Gourvernance\ExecutiveManagement\ManagementCommittee\TaskManagementCommittee;

class TaskManagementCommitteeObserver
{
    /**
     * Handle the TaskManagementCommittee "created" event.
     */
    public function created(TaskManagementCommittee $taskManagementCommittee): void
    {
        if(checkDealine($taskManagementCommittee->deadline)) {
            $taskManagementCommittee->alerts()->save(triggerAlert("RAPPEL | SESSION ADMINISTRATEUR", $taskManagementCommittee->libelle));
        }
    }

    /**
     * Handle the TaskManagementCommittee "updated" event.
     */
    public function updated(TaskManagementCommittee $taskManagementCommittee): void
    {
        //
    }

    /**
     * Handle the TaskManagementCommittee "deleted" event.
     */
    public function deleted(TaskManagementCommittee $taskManagementCommittee): void
    {
        //
    }

    /**
     * Handle the TaskManagementCommittee "restored" event.
     */
    public function restored(TaskManagementCommittee $taskManagementCommittee): void
    {
        //
    }

    /**
     * Handle the TaskManagementCommittee "force deleted" event.
     */
    public function forceDeleted(TaskManagementCommittee $taskManagementCommittee): void
    {
        //
    }
}
