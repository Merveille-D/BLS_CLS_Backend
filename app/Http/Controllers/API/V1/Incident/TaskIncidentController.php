<?php

namespace App\Http\Controllers\API\V1\Incident;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskIncident\GetCurrentTaskIncidentRequest;
use App\Http\Requests\TaskIncident\ListTaskIncidentRequest;
use App\Http\Requests\TaskIncident\UpdateTaskIncidentRequest;
use App\Models\Incident\TaskIncident;
use App\Repositories\Incident\TaskIncidentRepository;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TaskIncidentController extends Controller
{
    public function __construct(private TaskIncidentRepository $taskIncident) {

    }

    /**
     * Display a listing of the resource.
     */
    public function index(ListTaskIncidentRequest $request)
    {
        $task_incidents = $this->taskIncident->all($request);
        return api_response(true, "Liste des taches de l'incident ", $task_incidents, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(TaskIncident $taskIncident)
    {
        try {
            return api_response(true, "Information de la tache", $taskIncident, 200);
        }catch( ValidationException $e ) {
            return api_response(false, "Echec de la récupération des infos de la tache", $e->errors(), 422);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskIncidentRequest $request, TaskIncident $taskIncident)
    {
        $current_task_incident = TaskIncident::where('incident_id', $taskIncident->incident_id)->where('status', false)->first();
        if($current_task_incident->id != $taskIncident->id) {
            return api_response(false, "Ce n'est pas la tache suivante à modifier", null, 422);
        }

        try {
            $this->taskIncident->update($taskIncident, $request->all());
            return api_response(true, "Succès de l'enregistrement de la tache", $taskIncident, 200);
        }catch (ValidationException $e) {
                return api_response(false, "Echec de l'enregistrement de la tache", $e->errors(), 422);
        }
    }

    public function getCurrentTaskIncident(GetCurrentTaskIncidentRequest $request)
    {
        $task_incident = $this->taskIncident->getCurrentTask($request);
        return api_response(true, "Liste des taches de l'incident ", $task_incident, 200);
    }

}