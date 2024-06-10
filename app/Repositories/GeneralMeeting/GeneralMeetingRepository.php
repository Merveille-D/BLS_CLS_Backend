<?php
namespace App\Repositories\GeneralMeeting;

use App\Concerns\Traits\PDF\GeneratePdfTrait;
use App\Models\Gourvernance\GeneralMeeting\GeneralMeeting;
use App\Models\Gourvernance\GeneralMeeting\TaskGeneralMeeting;
use App\Models\Gourvernance\GourvernanceDocument;
use Illuminate\Support\Str;
use DateTime;
use Illuminate\Support\Facades\Auth;

class GeneralMeetingRepository
{
    use GeneratePdfTrait;

    public function __construct(private GeneralMeeting $meeting) {

    }

    /**
     * @param Request $request
     *
     * @return GeneralMeeting
     */
    public function store($request) {

        $date = new DateTime($request['meeting_date']);
        $reference = 'AG-' . '-' . $date->format('d') . '/' . $date->format('m') . '/' . $date->format('Y');
        $request['meeting_reference'] = $reference;

        $request['reference'] = generateReference('AG', $this->meeting);
        $request['created_by'] = Auth::user()->id;

        $general_meeting = $this->meeting->create($request->all());

        $this->createTasks($general_meeting);
        return $general_meeting;
    }

    /**
     * @param Request $request
     *
     * @return GeneralMeeting
     */
    public function update(GeneralMeeting $general_meeting, $request) {

        $current_date = new DateTime($request["meeting_date"]);
        $old_date = new DateTime($general_meeting->meeting_date);

        $date_diff = $current_date->diff($old_date);

        $general_meeting->update($request);

        if($date_diff->format('%R%a') != 0) {
            $this->createTasks($general_meeting);
        }

        return $general_meeting;
    }

    /**
     * @param Request $request
     *
     * @return GeneralMeeting
     */
    public function attachement($request) {

        $general_meeting = GeneralMeeting::find($request->general_meeting_id);
        $files = $request['files'];

        foreach($files as $item) {

            $fieldName = GeneralMeeting::TYPE_FILE_FIELD_VALUE[$item['type']];

            $generalMeeting = new GeneralMeeting();
            if ($generalMeeting->isFillable($fieldName)) {

                $general_meeting->update([
                    $fieldName => uploadFile( $item['file'], 'ag_documents'),
                    GeneralMeeting::DATE_FILE_FIELD[$fieldName] => now(),
                ]);
            }else {

                $fileUpload = new GourvernanceDocument();

                $fileUpload->name = getFileName($item['file']);
                $fileUpload->file = uploadFile($item['file'], 'ag_documents');
                $fileUpload->status = $general_meeting->status;

                $general_meeting->fileUploads()->save($fileUpload);
            }
        }

        return $general_meeting;
    }

    public function createTasks($general_meeting) {

        if($general_meeting->tasks()->count() > 0) {
            $general_meeting->tasks()->delete();
        }

        $known_tasks = TaskGeneralMeeting::TASKS;
        foreach($known_tasks as $type => $tasks) {
            foreach($tasks as $task) {
                $task['type'] = $type;
                $task['general_meeting_id'] = $general_meeting->id;
                $task['created_by'] = Auth::user()->id;

                if($type == "pre_ag") {
                    $meeting_date = new DateTime($general_meeting->meeting_date);
                    $sign = $task['days'] >= 0 ? 1 : -1;
                    $deadline = $meeting_date->modify($sign * abs($task['days']) . ' days');
                    $task['deadline'] = $deadline;
                }

                $new_task = TaskGeneralMeeting::create($task);
            }
        }

        return $general_meeting;
    }

    public function checkStatus() {

        $general_meetings = GeneralMeeting::where('meeting_date', '<', now())->get();
        foreach($general_meetings as $general_meeting) {
            $general_meeting->update(['status' => 'post_ag']);
        }

        return 0;
    }

    public function generatePdf($request){

        $general_meeting = GeneralMeeting::find($request['general_meeting_id']);

        $meeting_type = GeneralMeeting::GENERAL_MEETING_TYPES_VALUE[$general_meeting->type];

        $tasks = TaskGeneralMeeting::where('general_meeting_id', $general_meeting->id)
                                    ->whereIn('type', ['pre_ag', 'post_ag'])
                                    ->get();

        $filename = Str::slug($general_meeting->libelle). '_'.date('YmdHis') . '.pdf';

        $pdf =  $this->generateFromView( 'pdf.general_meeting.fiche_de_suivi',  [
            'tasks' => $tasks,
            'general_meeting' => $general_meeting,
            'meeting_type' => $meeting_type,
        ],$filename);

        return $pdf;
    }

}
