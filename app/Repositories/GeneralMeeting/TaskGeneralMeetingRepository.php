<?php
namespace App\Repositories\GeneralMeeting;

use App\Concerns\Traits\PDF\GeneratePdfTrait;
use App\Concerns\Traits\Transfer\AddTransferTrait;
use App\Models\Gourvernance\GeneralMeeting\GeneralMeeting;
use App\Models\Gourvernance\GeneralMeeting\TaskGeneralMeeting;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class TaskGeneralMeetingRepository
{
    use GeneratePdfTrait;
    use AddTransferTrait;

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
        $request['created_by'] = Auth::user()->id;

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

        if(isset($request['forward_title'])) {
            $this->add_transfer($taskGeneralMeeting, $request['forward_title'], $request['deadline_transfer'], $request['description'], $request['collaborators']);
        }
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

            $updateData = ['status' => $data['status']];
            if ($data['status']) {
                $updateData['completed_by'] = Auth::user()->id;
            }

            $taskGeneralMeeting->update($updateData);
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

        $meeting_type = __($general_meeting->type);

        $tasks = TaskGeneralMeeting::where('general_meeting_id', $general_meeting->id)
                                    ->where('type', $request['type'])
                                    ->get();
        $title = $request['type'] == 'checklist' ? 'Checklist' : 'Procedure';
        $filename = Str::slug($title .''. $general_meeting->libelle). '_'.date('YmdHis') . '.pdf';

        $pdf =  $this->generateFromView( 'pdf.general_meeting.checklist_and_procedure',  [
            'tasks' => $tasks,
            'general_meeting' => $general_meeting,
            'meeting_type' => $meeting_type,
            'title' => $title,
        ], $filename);
        return $pdf;
    }

}
