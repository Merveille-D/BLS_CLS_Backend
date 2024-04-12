<?php
namespace App\Repositories\Incident;

use App\Models\Incident\IncidentDocument;
use App\Models\Incident\TaskIncident;

class TaskIncidentRepository
{
    public function __construct(private TaskIncident $taskIncident) {

    }

    /**
     * @param Request $request
     *
     * @return TaskIncident
     */
    public function all($request) {

        $task_incidents = $this->taskIncident->where('incident_id', $request->incident_id)->get();
        return $task_incidents;
    }

    /**
     * @param Request $request
     *
     * @return TaskIncident
     */
    public function update(TaskIncident $taskIncident, $request) {

        if(isset($request['files'])) {
            foreach($request['files'] as $item) {

                    $fileUpload = new IncidentDocument();

                    $fileUpload->name = getFileName($item['file']);
                    $fileUpload->file = uploadFile($item['file'], 'ag_documents');

                    $taskIncident->fileUploads()->save($fileUpload);
            }
        }

        $taskIncident->update($request);

        $this->createNextTasks($taskIncident);

        return $taskIncident;
    }

    /**
     * @param Request $request
     *
     * @return TaskIncident
     */
    public function getCurrentTask($request) {

        $task_incidents = $this->taskIncident->where('incident_id', $request->incident_id)->where('status', false)->first();
        return $task_incidents;
    }


    private function createNextTasks($taskIncident) {

        $type = $taskIncident->code;
        $response = $taskIncident->response;


        $next_task = searchElementIndice(TaskIncident::TASKS, $type);

        if($next_task['next'] == false) {

            $incident = $taskIncident->incident;
            $incident->status = true;
            $incident->save();

            return true;
        }else if (is_array($next_task[$response])) {

            foreach ($next_task[$response] as $key => $task) {
                TaskIncident::create([
                    'title' => $task['title'],
                    'code' => $key,
                ]);
            }
        }

        return true;
    }


}
