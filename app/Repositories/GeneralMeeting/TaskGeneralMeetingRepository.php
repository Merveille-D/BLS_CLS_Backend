<?php
namespace App\Repositories\GeneralMeeting;

use App\Concerns\Traits\PDF\GeneratePdfTrait;
use App\Models\Gourvernance\GeneralMeeting\GeneralMeeting;
use App\Models\Gourvernance\GeneralMeeting\TaskGeneralMeeting;
use Carbon\Carbon;
use DateTime;

class TaskGeneralMeetingRepository
{
    use GeneratePdfTrait;

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

    public function generatePdf($request){

        $general_meeting = GeneralMeeting::find($request['general_meeting_id']);

        $meeting_type = GeneralMeeting::GENERAL_MEETING_TYPES_VALUE[$general_meeting->type];

        $tasks = TaskGeneralMeeting::where('general_meeting_id', $general_meeting->id)
                                    ->whereIn('type', ['checklist', 'procedure'])
                                    ->get();

        $pdf =  $this->generateFromView( 'pdf.general_meeting.checklist_and_procedure',  [
            'tasks' => $tasks,
            'general_meeting' => $general_meeting,
            'meeting_type' => $meeting_type,
        ]);
        return $pdf;
    }

}
