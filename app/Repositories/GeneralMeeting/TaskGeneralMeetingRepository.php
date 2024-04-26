<?php
namespace App\Repositories\GeneralMeeting;

use App\Models\Gourvernance\GeneralMeeting\GeneralMeeting;
use App\Models\Gourvernance\GeneralMeeting\TaskGeneralMeeting;
use Carbon\Carbon;
use DateTime;

class TaskGeneralMeetingRepository
{
    public function __construct(private TaskGeneralMeeting $task) {

    }

    /**
     * @param Request $request
     *
     * @return TaskGeneralMeeting
     */
    public function all($request) {

        $task_general_meetings = $this->task
            ->where('general_meeting_id', $request->general_meeting_id)
            ->when(request('type') !== null, function($query) {
                $query->where('type', request('type'));
            }, function($query) {
                $query->whereNotIn('type', ['checklist', 'procedure']);
            })
            ->get();

        return $task_general_meetings;
    }

    /**
     * @param Request $request
     *
     * @return TaskGeneralMeeting
     */
    public function store($request) {

        if(!$request->has('type')) {
            $general_meeting = GeneralMeeting::find($request['general_meeting_id']);
            $meetingDate = Carbon::parse($general_meeting->meeting_date);
            $request['type'] = $meetingDate->isPast() ? 'post_ag' : 'pre_ag';
        }

        $task_general_meeting = $this->task->create($request->all());

        return $task_general_meeting;
    }

    /**
     * @param Request $request
     *
     * @return TaskGeneralMeeting
     */
    public function update(TaskGeneralMeeting $taskGeneralMeeting, $request) {
        $taskGeneralMeeting->update($request);
        return $taskGeneralMeeting;
    }

    /**
     * @param Request $request
     *
     * @return TaskGeneralMeeting
     */

    public function updateStatus($request) {
        foreach ($request['tasks'] as $data) {
            $taskGeneralMeeting = $this->task->findOrFail($data['id']);
            $taskGeneralMeeting->update(['status' => $data['status']]);
            $updatedTasks[] = $taskGeneralMeeting;


            if($taskGeneralMeeting->type === 'pre_ag') {
                $general_meeting = $taskGeneralMeeting->general_meeting();
                if($taskGeneralMeeting->deadline === $general_meeting->meeting_date) {
                    $general_meeting->update(['status' => 'post_ag']);
                }
            }

        }

        return $taskGeneralMeeting;
    }

    /**
     * @param Request $request
     *
     * @return TaskGeneralMeeting
     */
    public function deleteArray($request) {
        foreach ($request['tasks'] as $data) {
            $taskGeneralMeeting = $this->task->findOrFail($data['id']);
            $taskGeneralMeeting->delete();
        }

        return true;
    }

    public function updateAlertTask($task) {

        // $task = TaskGeneralMeeting::where('status', false)
        //                             ->orderByDeadline()
        //                             ->firstOrFail();

        $alertsExist = $task->alerts()->exists();

        if ($alertsExist) {
            $alertsToDelete = $task->alerts()->whereNotIn('deadline', [$task->deadline])->get();

            if ($alertsToDelete->isEmpty()) {

                $alertsToDelete->each->delete();

                $days = $this->diffInDays($task->deadline, ($this->nextTask()->deadline ?? $task->deadline->addDays(10) ));
                $this->createAlert($task, $days);
            }
        } else {
            $days = $this->diffInDays($task->deadline, $this->nextTask()->deadline);
            $this->createAlert($task, $days);
        }

        return $task;
    }

    private function createAlert($task, $days) {
        $deadlines = [
            $task->deadline->addDays(0.20 * $days),
            $task->deadline->addDays(0.60 * $days),
            $task->deadline->addDays(0.95 * $days),
        ];

        $types = ['info', 'warning', 'urgent'];

        foreach ($deadlines as $index => $deadline) {
            $task->alerts()->create([
                'title' => $task->title,
                'deadline' => $task->deadline,
                'message' => $task->libelle,
                'type' => $types[$index],
                'trigger_at' => $deadline,
            ]);
        }
    }

    private function nextTask() {
        $nextTask = TaskGeneralMeeting::where('status', false)
                                        ->orderByDeadline()
                                        ->skip(1)
                                        ->firstOrFail();
        return $nextTask ?? null;
    }

    private function diffInDays($date1, $date2) {
        $deadline = Carbon::parse($date1);
        $nextDeadline = Carbon::parse($date2);
        $days = $deadline->diffInDays($nextDeadline);

        return $days;
    }


}
