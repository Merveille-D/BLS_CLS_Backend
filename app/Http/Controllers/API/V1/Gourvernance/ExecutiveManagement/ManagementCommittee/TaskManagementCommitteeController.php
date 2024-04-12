<?php

namespace App\Http\Controllers\API\V1\Gourvernance\ExecutiveManagement\ManagementCommittee;

use App\Http\Controllers\Controller;
use App\Http\Requests\ManagementCommittee\ListTaskManagementCommitteeRequest;
use App\Http\Requests\TaskManagementCommittee\DeleteTaskManagementCommitteeRequest;
use App\Http\Requests\TaskManagementCommittee\StoreTaskManagementCommitteeRequest;
use App\Http\Requests\TaskManagementCommittee\UpdateStatusTaskManagementCommitteeRequest;
use App\Http\Requests\TaskManagementCommittee\UpdateTaskManagementCommitteeRequest;
use App\Models\Gourvernance\ExecutiveManagement\ManagementCommittee\TaskManagementCommittee;
use App\Repositories\ManagementCommittee\TaskManagementCommitteeRepository;
use Illuminate\Validation\ValidationException;

class TaskManagementCommitteeController extends Controller
{

    public function __construct(private TaskManagementCommitteeRepository $task) {

    }

    /**
     * Display a listing of the resource.
     */
    public function index(ListTaskManagementCommitteeRequest $request)
    {
        $task_general_meetings = $this->task->all($request);
        return api_response(true, "Liste des Taches du CD", $task_general_meetings, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskManagementCommitteeRequest $request)
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
    public function show(TaskManagementCommittee $taskManagementCommittee)
    {
        try {

            return api_response(true, "Information de la tache", $taskManagementCommittee, 200);
        }catch( ValidationException $e ) {
            return api_response(false, "Echec de la récupération des infos de la tache", $e->errors(), 422);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskManagementCommitteeRequest $request, TaskManagementCommittee $taskManagementCommittee)
    {
        try {
            $this->task->update($taskManagementCommittee, $request->all());
            return api_response(true, "Succès de l'enregistrement de la tache", $taskManagementCommittee, 200);
        }catch (ValidationException $e) {
                return api_response(false, "Echec de l'enregistrement de la tache", $e->errors(), 422);
        }
    }

    public function deleteArrayTaskManagementCommittee(DeleteTaskManagementCommitteeRequest $request)
    {
        try {
            $this->task->deleteArray($request);
            return api_response(true, "Succès de la suppression des taches", null, 200);
        } catch (ValidationException $e) {
            return api_response(false, "Echec de la suppression des taches", $e->errors(), 422);
        }
    }

    public function updateStatusTaskManagementCommittee(UpdateStatusTaskManagementCommitteeRequest $request)
    {
        try {
            $this->task->updateStatus($request);
            return api_response(true, "Succès de la mise à jour des taches", null, 200);
        } catch (ValidationException $e) {
            return api_response(false, "Echec de la mise à jour des taches", $e->errors(), 422);
        }
    }
}
