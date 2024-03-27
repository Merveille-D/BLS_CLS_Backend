<?php

namespace App\Http\Controllers\API\V1\Gourvernance\BordDirectors\Sessions;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskSessionAdministrator\StoreTaskSessionAdministratorRequest;
use App\Http\Requests\TaskSessionAdministrator\UpdateTaskSessionAdministratorRequest;
use App\Models\Gourvernance\BoardDirectors\Sessions\TaskSessionAdministrator;
use App\Models\Gourvernance\GeneralMeeting\TaskGeneralMeeting;
use App\Repositories\TaskSessionAdministratorRepository;
use Illuminate\Validation\ValidationException;

class TaskSessionAdministratorController extends Controller
{

    public function __construct(private TaskSessionAdministratorRepository $task) {

    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $task_general_meetings = TaskGeneralMeeting::all();
        return api_response(true, "Liste des Taches", $task_general_meetings, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskSessionAdministratorRequest $request)
    {
        try {
            $task_general_meeting = $this->task->store($request);
            return api_response(true, "Succès de l'enregistrement de la tache", $task_general_meeting, 200);
        }catch (ValidationException $e) {
                return api_response(false, "Echec de l'enregistrement de la tache", $e->errors(), 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(TaskSessionAdministrator $taskSessionAdministrator)
    {
        try {

            return api_response(true, "Information de la tache", $taskSessionAdministrator, 200);
        }catch( ValidationException $e ) {
            return api_response(false, "Echec de la récupération des infos de la tache", $e->errors(), 422);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskSessionAdministratorRequest $request, TaskSessionAdministrator $taskSessionAdministrator)
    {
        try {
            $taskSessionAdministrator = $this->task->update($request);
            return api_response(true, "Succès de l'enregistrement de la tache", $taskSessionAdministrator, 200);
        }catch (ValidationException $e) {
                return api_response(false, "Echec de l'enregistrement de la tache", $e->errors(), 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TaskSessionAdministrator $taskSessionAdministrator)
    {
        //
    }
}
