<?php

namespace App\Http\Controllers\API\V1\Gourvernance\BordDirectors\Sessions;

use App\Http\Controllers\Controller;
use App\Http\Requests\SessionAdministrator\ListTaskSessionAdministratorRequest;
use App\Http\Requests\TaskSessionAdministrator\DeleteTaskSessionAdministratorRequest;
use App\Http\Requests\TaskSessionAdministrator\StoreTaskSessionAdministratorRequest;
use App\Http\Requests\TaskSessionAdministrator\UpdateStatusTaskSessionAdministratorRequest;
use App\Http\Requests\TaskSessionAdministrator\UpdateTaskSessionAdministratorRequest;
use App\Models\Gourvernance\BoardDirectors\Sessions\TaskSessionAdministrator;
use App\Repositories\SessionAdministrator\TaskSessionAdministratorRepository;
use Illuminate\Validation\ValidationException;

class TaskSessionAdministratorController extends Controller
{

    public function __construct(private TaskSessionAdministratorRepository $task) {

    }

    /**
     * Display a listing of the resource.
     */
    public function index(ListTaskSessionAdministratorRequest $request)
    {
        $task_general_meetings = $this->task->all($request);
        return api_response(true, "Liste des Taches du CA", $task_general_meetings, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskSessionAdministratorRequest $request)
    {
        try {
            $task_session_administrator = $this->task->store($request);
            return api_response(true, "Succès de l'enregistrement de la tache", $task_session_administrator, 200);
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
            $this->task->update($taskSessionAdministrator, $request->all());
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

    public function deleteArrayTaskSessionAdministrator(DeleteTaskSessionAdministratorRequest $request)
    {
        try {
            $this->task->deleteArray($request);
            return api_response(true, "Succès de la suppression des taches", null, 200);
        } catch (ValidationException $e) {
            return api_response(false, "Echec de la suppression des taches", $e->errors(), 422);
        }
    }

    public function updateStatusTaskSessionAdministrator(UpdateStatusTaskSessionAdministratorRequest $request)
    {
        try {
            $this->task->updateStatus($request);
            return api_response(true, "Succès de la mise à jour des taches", null, 200);
        } catch (ValidationException $e) {
            return api_response(false, "Echec de la mise à jour des taches", $e->errors(), 422);
        }
    }
}
