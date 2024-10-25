<?php

namespace App\Repositories\Alert;

use App\Models\Alert\Alert;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;

class AlertRepository
{
    public function __construct(private Alert $alert) {}

    public function triggerModuleAlert()
    {

        $alertModules = Alert::ALERT_MODULES;

        foreach ($alertModules as $alertModule) {
            $currentTasks = $this->currentTask($alertModule['model']);

            if (! $currentTasks->isEmpty()) {
                foreach ($currentTasks as $task) {

                    $task->libelle = ($task->title) ? $task->title : $task->libelle;
                    $task->title = $task->folder;
                    $task->type = $alertModule['type'];

                    $this->updateAlertTask($task, $this->oldTask($alertModule['model']));
                }
            }
        }

        return true;
    }

    private function updateAlertTask($current_task, $old_task)
    {

        $alertsExist = $current_task->alerts()->exists();

        if ($alertsExist) {

            $alertsToDelete = $current_task->alerts()->where('deadline', $current_task->deadline)->get();

            if ($alertsToDelete->isEmpty()) {
                $alertsToDelete->each->delete();

                $days = $this->diffInDays($current_task->deadline, ($old_task->deadline ?? $current_task->created_at));
                $this->createAlert($current_task, $days);
            }
        } else {
            $days = $this->diffInDays($current_task->deadline, ($old_task->deadline ?? $current_task->created_at));
            $this->createAlert($current_task, $days);
        }

        return $current_task;
    }

    private function createAlert($current_task, $days)
    {

        $deadline = Carbon::parse($current_task->deadline);
        $deadlines = [
            $deadline->addDays(0.20 * $days),
            // $deadline->addDays(0.60 * $days),
            $deadline->addDays(0.95 * $days),
        ];

        // $priorities = ['info', 'warning', 'urgent'];
        $priorities = ['urgent'];

        foreach ($deadlines as $index => $deadline) {
            $current_task->alerts()->create([
                'title' => $current_task->title,
                'deadline' => $current_task->deadline,
                'message' => $current_task->libelle,
                'priority' => $priorities[$index],
                'type' => $current_task->type,
                // 'trigger_at' => $deadline,
                'trigger_at' => Carbon::now()->addSeconds(5),
            ]);
        }
    }

    private function diffInDays($date1, $date2)
    {
        $deadline = Carbon::parse($date1);
        $nextDeadline = Carbon::parse($date2);
        $days = $deadline->diffInDays($nextDeadline);

        return $days;
    }

    private function currentTask($modelClass)
    {

        $query = $modelClass::query()
            ->where('status', false)
            ->where('deadline', '>', now());

        if (Schema::hasColumn((new $modelClass)->getTable(), 'type')) {
            $query->whereNotIn('type', ['checklist', 'procedure']);
        }

        $currentTasks = $query->orderBy('deadline')->get();

        if (! $currentTasks->isEmpty()) {
            $firstTask = $currentTasks->first();

            $firstDeadline = Carbon::parse($firstTask->deadline);

            $tasksWithSameDeadline = $currentTasks->filter(function ($task) use ($firstDeadline) {
                $taskDeadline = Carbon::parse($task->deadline);

                return $taskDeadline->equalTo($firstDeadline);
            });
        }

        return ($currentTasks->isEmpty()) ? $currentTasks : $tasksWithSameDeadline;
    }

    private function oldTask($modelClass)
    {

        $query = $modelClass::query()
            ->where('deadline', '<', now());

        if (Schema::hasColumn((new $modelClass)->getTable(), 'type')) {
            $query->whereNotIn('type', ['checklist', 'procedure']);
        }

        $oldTask = $query->orderBy('deadline', 'desc')->first();

        return $oldTask ?? null;
    }
}
