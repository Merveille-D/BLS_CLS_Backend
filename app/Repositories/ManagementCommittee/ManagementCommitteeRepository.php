<?php
namespace App\Repositories\ManagementCommittee;

use App\Models\Gourvernance\ExecutiveManagement\ManagementCommittee\ManagementCommittee;
use App\Models\Gourvernance\ExecutiveManagement\ManagementCommittee\TaskManagementCommittee;
use App\Models\Gourvernance\GourvernanceDocument;
use DateTime;

class ManagementCommitteeRepository
{
    public function __construct(private ManagementCommittee $session) {

    }

    /**
     * @param Request $request
     *
     * @return ManagementCommittee
     */
    public function store($request) {

        $date = new DateTime(now());
        $reference = 'CD-' . (ManagementCommittee::max('id') + 1) . '-' . $date->format('d') . '/' . $date->format('m') . '/' . $date->format('Y');
        $request['reference'] = $reference;

        $management_committee = $this->session->create($request->all());

        $this->createTasks($management_committee);

        return $management_committee;
    }

    /**
     * @param Request $request
     *
     * @return management_committee
     */
    public function update(ManagementCommittee $management_committee, $request) {

        $current_date = new DateTime($request["session_date"]);
        $old_date = new DateTime($management_committee->session_date);

        $date_diff = $current_date->diff($old_date);
        if($date_diff->format('%R%a') != 0) {
            $this->createTasks($management_committee);
        }

        $management_committee->update($request);

        return $management_committee;
    }

    /**
     * @param Request $request
     *
     * @return ManagementCommittee
     */
    public function attachement($request) {

        $management_committee = ManagementCommittee::find($request->management_committee_id);

        $files = $request['files'];

        foreach($files as $item) {

            $fieldName = ManagementCommittee::TYPE_FILE_FIELD_VALUE[$item['type']];

            $ManagementCommittee = new ManagementCommittee();
            if ($ManagementCommittee->isFillable($fieldName)) {

                $management_committee->update([
                    $fieldName => uploadFile( $item['file'], 'ca_documents'),
                    ManagementCommittee::DATE_FILE_FIELD[$fieldName] => now(),
                ]);
            }else {

                $fileUpload = new GourvernanceDocument();

                $fileUpload->name = getFileName($item['file']);
                $fileUpload->file = uploadFile($item['file'], 'ca_documents');
                $fileUpload->status = $management_committee->status;

                $management_committee->fileUploads()->save($fileUpload);
            }
        }

        return $management_committee;
    }

    public function createTasks($management_committee) {

        if($management_committee->tasks()->count() > 0) {
            $management_committee->tasks()->delete();
        }

        $known_tasks = TaskManagementCommittee::TASKS;
        foreach($known_tasks as $type => $tasks) {
            foreach($tasks as $task) {
                $task['type'] = $type;
                $task['management_committee_id'] = $management_committee->id;

                if($type == "pre_cd") {
                    $session_date = new DateTime($management_committee->session_date);
                    $sign = $task['days'] >= 0 ? 1 : -1;
                    $deadline = $session_date->modify($sign * abs($task['days']) . ' days');
                    $task['deadline'] = $deadline;
                }
                TaskManagementCommittee::create($task);
            }
        }

        return $management_committee;
    }

    public function checkFilesFilled($management_committee) {

        $fileFields = ManagementCommittee::FILE_FIELD;
        $allFilled = true;

        foreach ($fileFields as $field) {
            if (empty($management_committee->$field)) {
                $allFilled = false;
                break;
            }
        }

        if ($allFilled) {
            $management_committee->update([
                'status' => 'post_ag',
            ]);
        }

        return $management_committee;
    }
}
