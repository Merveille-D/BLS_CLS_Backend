<?php
namespace App\Repositories;

use App\Models\Gourvernance\BoardDirectors\Sessions\SessionAdministrator;
use App\Models\Gourvernance\BoardDirectors\Sessions\TaskSessionAdministrator;
use App\Models\Gourvernance\GourvernanceDocument;
use DateTime;

class SessionAdministratorRepository
{
    public function __construct(private SessionAdministrator $session) {

    }

    /**
     * @param Request $request
     *
     * @return SessionAdministrator
     */
    public function store($request) {

        $date = new DateTime(now());
        $reference = 'CA-' . (SessionAdministrator::max('id') + 1) . '-' . $date->format('d') . '' . $date->format('m') . '' . $date->format('Y');
        $request['reference'] = $reference;

        $session_administrator = $this->session->create($request->all());
        $this->createTasks($session_administrator);

        return $session_administrator;
    }

    /**
     * @param Request $request
     *
     * @return session_administrator
     */
    public function update(SessionAdministrator $session_administrator, $request) {

        $session_administrator->update($request);

        if($request["session_date"] != $session_administrator->session_date) {
            $this->createTasks($session_administrator);
        }
        return $session_administrator;
    }

    /**
     * @param Request $request
     *
     * @return SessionAdministrator
     */
    public function attachement($request) {

        $session_administrator = SessionAdministrator::find($request->session_administrator_id);

        $files = $request['files'];

        foreach($files as $item) {

            $fieldName = SessionAdministrator::TYPE_FILE_FIELD_VALUE[$item['type']];

            $sessionAdministrator = new SessionAdministrator();
            if ($sessionAdministrator->isFillable($fieldName)) {

                $session_administrator->update([
                    $fieldName => uploadFile( $item['file'], 'ca_documents'),
                    SessionAdministrator::DATE_FILE_FIELD[$fieldName] => now(),
                ]);
            }else {

                $fileUpload = new GourvernanceDocument();

                $fileUpload->name = getFileName($item['file']);
                $fileUpload->file = uploadFile($item['file'], 'ca_documents');
                $fileUpload->status = $session_administrator->status;

                $session_administrator->fileUploads()->save($fileUpload);
            }
        }

        $this->checkFilesFilled($session_administrator);

        return $session_administrator;
    }

    public function createTasks($session_administrator) {

        if($session_administrator->tasks()->count() > 0) {
            $session_administrator->tasks()->delete();
        }

        $known_tasks = TaskSessionAdministrator::TASKS;
        foreach($known_tasks as $type => $tasks) {
            foreach($tasks as $task) {
                $task['type'] = $type;
                $task['session_administrator_id'] = $session_administrator->id;

                if($type == "pre_ca") {
                    $session_date = new DateTime($session_administrator->session_date);
                    $sign = $task['days'] >= 0 ? 1 : -1;
                    $deadline = $session_date->modify($sign * abs($task['days']) . ' days');
                    $task['deadline'] = $deadline;
                }
                TaskSessionAdministrator::create($task);
            }
        }

        return $session_administrator;
    }

    public function checkFilesFilled($session_administrator) {

        $fileFields = SessionAdministrator::FILE_FIELD;
        $allFilled = true;

        foreach ($fileFields as $field) {
            if (empty($session_administrator->$field)) {
                $allFilled = false;
                break;
            }
        }

        if ($allFilled) {
            $session_administrator->update([
                'status' => 'post_ag',
            ]);
        }

        return $session_administrator;
    }
}
