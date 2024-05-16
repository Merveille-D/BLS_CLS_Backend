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

        $previousDeadline = null;

        foreach ($tasks as $key => $task) {
            $deadline = $previousDeadline ? $previousDeadline->addDays($task['delay']) : $incident->created_at->addDays($task['delay']);

            TaskIncident::create([
                'title' => $task['title'],
                'code' => $key,
                'incident_id' => $incident->id,
                'deadline' => $deadline,
            ]);

            $previousDeadline = $deadline;
        }

        return true;
    }


}
