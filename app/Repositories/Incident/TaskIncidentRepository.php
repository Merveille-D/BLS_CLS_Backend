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

        $task_incidents = $this->taskIncident->where('incident_id', $request->incident_id)->get()->map(function ($taskIncident) {
            $taskIncident->form = $taskIncident->form;
            return $taskIncident;
        });
        return $task_incidents;
    }

    /**
     * @param Request $request
     *
     * @return TaskIncident
     */
    public function update(TaskIncident $taskIncident, $request) {

        if(isset($request['documents'])) {
            foreach($request['documents'] as $item) {

                    $fileUpload = new IncidentDocument();

                    $fileUpload->name = $item['name'];
                    $fileUpload->file = uploadFile($item['file'], 'incident_documents');

                    $taskIncident->fileUploads()->save($fileUpload);
            }
        }

        if(isset($request['raised_hand'])) {
            $request['raised_hand'] = ($request['raised_hand'] === 'yes') ? true : false;
        }

        if(isset($request['conversion_certificate'])) {
            $request['conversion_certificate'] = ($request['conversion_certificate'] === 'yes') ? true : false;
        }

        $request['status'] = true;

        $this->createNextTasks($taskIncident);

        $taskIncident->update($request);

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

        $next_task = searchElementIndice(TaskIncident::TASKS, $type);

        if(isset($next_task['next'])) {

            if($next_task['next'] === false) {

                $incident = $taskIncident->incident;
                $incident->status = true;
                $incident->save();

                return true;
            }else {
                $response = $taskIncident->raised_hand ?? $taskIncident->conversion_certificate;
                foreach ($next_task['next'][$response] as $key => $task) {
                    TaskIncident::create([
                        'title' => $task['title'],
                        'code' => $key,
                        'incident_id' => $taskIncident->incident_id,
                    ]);
                }
            }

        }



        return true;
    }

}
