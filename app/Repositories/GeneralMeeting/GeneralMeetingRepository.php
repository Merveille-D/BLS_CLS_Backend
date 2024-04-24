<?php
namespace App\Repositories\GeneralMeeting;

use App\Models\Gourvernance\GeneralMeeting\GeneralMeeting;
use App\Models\Gourvernance\GeneralMeeting\TaskGeneralMeeting;
use App\Models\Gourvernance\GourvernanceDocument;
use DateTime;

class GeneralMeetingRepository
{
    public function __construct(private GeneralMeeting $meeting) {

    }

    /**
     * @param Request $request
     *
     * @return GeneralMeeting
     */
    public function store($request) {

        $date = new DateTime($request['meeting_date']);
        $reference = 'AG-' . (GeneralMeeting::max('id') + 1) . '-' . $date->format('d') . '/' . $date->format('m') . '/' . $date->format('Y');
        $request['reference'] = $reference;

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

        $general_meeting->update($request);

        $current_date = new DateTime($request["meeting_date"]);
        $old_date = new DateTime($general_meeting->meeting_date);

        $date_diff = $current_date->diff($old_date);

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

        // $this->checkFilesFilled($general_meeting);

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

                if($type == "pre_ag") {
                    $meeting_date = new DateTime($general_meeting->meeting_date);
                    $sign = $task['days'] >= 0 ? 1 : -1;
                    $deadline = $meeting_date->modify($sign * abs($task['days']) . ' days');
                    $task['deadline'] = $deadline;
                }

                $new_task = TaskGeneralMeeting::create($task);

                if(checkDealine($new_task->deadline)) {
                    $new_task->alerts()->save(triggerAlert("RAPPEL | ASSEMBLEE GENERALE", $new_task->libelle));
                }
            }
        }

        return $general_meeting;
    }

    public function checkFilesFilled($general_meeting) {

        $fileFields = GeneralMeeting::FILE_FIELD;
        $allFilled = true;

        foreach ($fileFields as $field) {
            if (empty($general_meeting->$field)) {
                $allFilled = false;
                break;
            }
        }

        if ($allFilled) {
            $general_meeting->update([
                'status' => 'post_ag',
            ]);
        }

        return $general_meeting;
    }


}
