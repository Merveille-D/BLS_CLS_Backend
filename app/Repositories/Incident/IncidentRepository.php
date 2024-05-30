<?php
namespace App\Repositories\Incident;

use App\Models\Incident\Incident;
use App\Models\Incident\TaskIncident;
use Illuminate\Support\Facades\Auth;

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

        $request['created_by'] = Auth::user()->id;
        $incident = $this->incident->create($request);

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
                'created_by' => Auth::user()->id,
            ]);

            $previousDeadline = $deadline;
        }

        return true;
    }


}
