<?php
namespace App\Repositories\Incident;

use App\Models\Incident\Incident;
use App\Models\Incident\TaskIncident;

class IncidentRepository
{
    public function __construct(private Incident $incident) {

    }

    /**
     * @param Request $request
     *
     * @return Incident
     */
    public function store($request) {

        $incident = $this->incident->create($request->all());

        $this->createTasks($incident);
        return $incident;
    }

     /**
     * @param Request $request
     *
     * @return Incident
     */
    public function update(Incident $incident, $request) {

        $incident->update($request);
        return $incident;
    }

    private function createTasks($incident) {

        $type = $incident->type;
        $client = $incident->client;

        $tasks = TaskIncident::TASKS[$type][$client];

        foreach ($tasks as $key => $task) {
            TaskIncident::create([
                'title' => $task['title'],
                'code' => $key,
                'incident_id' => $incident->id,
            ]);
        }

        return true;
    }


}
