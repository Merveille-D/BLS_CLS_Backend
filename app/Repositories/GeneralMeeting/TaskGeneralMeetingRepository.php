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

    public function triggertAlert() {
        $response = $this->currentTask() ? updateAlertTask($this->currentTask(), $this->nextTask()) : false;
        return $response;
    }


    private function currentTask() {
        $currentTask = TaskGeneralMeeting::where('status', false)
                                        ->whereNotIn('type', ['checklist', 'procedure'])
                                        ->orderByDeadline()
                                        ->firstOrFail();

        $currentTask->title = "RAPPEL | ASSEMBLEE GENERALE";
        $currentTask->type = "general_meeting";

        return $currentTask;
    }

    private function nextTask() {
        $nextTask = TaskGeneralMeeting::where('status', false)
                                        ->whereNotIn('type', ['checklist', 'procedure'])
                                        ->orderByDeadline()
                                        ->skip(1)
                                        ->firstOrFail();
        return $nextTask ?? null;
    }

}
