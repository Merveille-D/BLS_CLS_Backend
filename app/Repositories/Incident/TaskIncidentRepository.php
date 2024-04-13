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
        $request['status'] = true;
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

        $task_incident = $this->taskIncident->where('incident_id', $request->incident_id)->where('status', false)->first();
        return $task_incident;
    }


    private function createNextTasks($taskIncident) {

        $type = $taskIncident->code;
        $response = $taskIncident->raised_hand;


        $next_task = searchElementIndice(TaskIncident::TASKS, $type);

        if($next_task['next'] == false) {

            $incident = $taskIncident->incident;
            $incident->status = true;
            $incident->save();

            return true;
        }else if (is_array($next_task['next'][$response])) {

            foreach ($next_task['next'][$response] as $key => $task) {
                TaskIncident::create([
                    'title' => $task['title'],
                    'code' => $key,
                    'incident_id' => $taskIncident->incident_id,
                ]);
            }
        }

        return true;
    }


}