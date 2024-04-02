<?php
namespace App\Repositories;

use App\Models\FileUpload;
use App\Models\Gourvernance\GeneralMeeting\GeneralMeeting;
use App\Models\Gourvernance\GeneralMeeting\TaskGeneralMeeting;
use Carbon\Carbon;

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
                $query->whereNotIn('type', ['checklist', 'procedures']);
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
}
