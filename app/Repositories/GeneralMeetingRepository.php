<?php
namespace App\Repositories;

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

        $date = new DateTime(now());
        $reference = 'AG-' . (GeneralMeeting::max('id') + 1) . '-' . $date->format('d') . '' . $date->format('m') . '' . $date->format('Y');
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
        $this->createTasks($general_meeting);

        return $general_meeting;
    }

    /**
     * @param Request $request
     *
     * @return GeneralMeeting
     */
    public function attachement($request) {

        $general_meeting = GeneralMeeting::find($request->general_meeting_id);
        $fieldName = GeneralMeeting::TYPE_FILE_FIELD_VALUE[$request['files']['type']];

        $generalMeeting = new GeneralMeeting();
        if ($generalMeeting->isFillable($fieldName)) {

            $general_meeting->update([
                $fieldName => uploadFile( $request['files']['file'], 'ag_documents'),
                GeneralMeeting::DATE_FILE_FIELD[$fieldName] => now(),
            ]);
        }else {

            $fileUpload = new GourvernanceDocument();

            $fileUpload->file = uploadFile($request['files']['file'], 'ag_documents');
            $fileUpload->status = $general_meeting->status;

            $general_meeting->fileUploads()->save($fileUpload);
        }

        $this->checkFilesFilled($general_meeting);

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
                TaskGeneralMeeting::create($task);
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
