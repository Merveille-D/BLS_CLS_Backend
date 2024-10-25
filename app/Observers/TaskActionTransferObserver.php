<?php

namespace App\Observers;

use App\Models\Shareholder\TaskActionTransfer;

class TaskActionTransferObserver
{
    /**
     * Handle the TaskActionTransfer "created" event.
     */
    public function created(TaskActionTransfer $TaskActionTransfer): void {}

    /**
     * Handle the TaskActionTransfer "updated" event.
     */
    public function updated(TaskActionTransfer $taskActionTransfer): void
    {
        if ($taskActionTransfer->status) {
            $alertsExist = $taskActionTransfer->alerts()->delete();
        }
    }

    /**
     * Handle the TaskActionTransfer "deleted" event.
     */
    public function deleted(TaskActionTransfer $TaskActionTransfer): void
    {
        //
    }

    /**
     * Handle the TaskActionTransfer "restored" event.
     */
    public function restored(TaskActionTransfer $TaskActionTransfer): void
    {
        //
    }

    /**
     * Handle the TaskActionTransfer "force deleted" event.
     */
    public function forceDeleted(TaskActionTransfer $TaskActionTransfer): void
    {
        //
    }
}
