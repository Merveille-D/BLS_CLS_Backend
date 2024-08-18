<?php

namespace App\Observers\Guarantee;

use App\Concerns\Traits\Alert\AddAlertTrait;
use App\Models\Alert\Alert;
use App\Models\Guarantee\GuaranteeTask;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class GuaranteeTaskObserver
{
    use AddAlertTrait;
    /**
     * Handle the GuaranteeTask "created" event.
     */
    public function created(GuaranteeTask $guaranteeTask): void
    {
        // if ($guaranteeTask->code == 'created') {
        //     dd($guaranteeTask->taskable?->next_task?->title);
        //     $this->new_alert($guaranteeTask, 'RAPPEL | '. $guaranteeTask->taskable?->next_task?->title ?? 'Tâche', $data['message'] ?? 'TEST', $guaranteeTask->taskable?->security ?? 'guarantee', Carbon::now()->addDays(3), Alert::STATUS[2] ?? 'urgent');
        // }
    }

    /**
     * Handle the GuaranteeTask "updated" event.
     */
    public function updated(GuaranteeTask $guaranteeTask): void
    {
        if ($guaranteeTask->status == true) {
            $this->new_alert($guaranteeTask, 'RAPPEL    | '. __('security.'.$guaranteeTask->taskable?->name ?? ''), __($guaranteeTask->taskable?->next_task?->title ?? ''), $guaranteeTask->taskable?->security ?? 'guarantee', Carbon::now()->addDays(3), Alert::STATUS[2] ?? 'urgent');
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
