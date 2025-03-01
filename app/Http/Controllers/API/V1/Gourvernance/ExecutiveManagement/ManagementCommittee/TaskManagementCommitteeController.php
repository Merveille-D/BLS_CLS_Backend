<?php

namespace App\Http\Controllers\API\V1\Gourvernance\ExecutiveManagement\ManagementCommittee;

use App\Http\Controllers\Controller;
use App\Http\Requests\ManagementCommittee\GeneratePdfManagementCommitteeRequest;
use App\Http\Requests\ManagementCommittee\ListTaskManagementCommitteeRequest;
use App\Http\Requests\TaskManagementCommittee\DeleteTaskManagementCommitteeRequest;
use App\Http\Requests\TaskManagementCommittee\StoreTaskManagementCommitteeRequest;
use App\Http\Requests\TaskManagementCommittee\UpdateStatusTaskManagementCommitteeRequest;
use App\Http\Requests\TaskManagementCommittee\UpdateTaskManagementCommitteeRequest;
use App\Http\Resources\ManagementCommittee\TaskManagementCommitteeResource;
use App\Models\Gourvernance\ExecutiveManagement\ManagementCommittee\TaskManagementCommittee;
use App\Repositories\ManagementCommittee\TaskManagementCommitteeRepository;
use Illuminate\Validation\ValidationException;
use Throwable;

class TaskManagementCommitteeController extends Controller
{
    public function __construct(private TaskManagementCommitteeRepository $task) {}

    /**
     * Display a listing of the resource.
     */
    public function index(ListTaskManagementCommitteeRequest $request)
    {
        $task_management_committees = $this->task->all($request);

        return api_response(true, 'Liste des Taches du CD', TaskManagementCommitteeResource::collection($task_management_committees), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskManagementCommitteeRequest $request)
    {
        try {
            $task_management_committee = $this->task->store($request);

            return api_response(true, "Succès de l'enregistrement de la tache", new TaskManagementCommitteeResource($task_management_committee), 200);
        } catch (ValidationException $e) {
            return api_response(false, "Echec de l'enregistrement de la tache", $e->errors(), 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(TaskManagementCommittee $taskManagementCommittee)
    {
        try {

            return api_response(true, 'Information de la tache', new TaskManagementCommitteeResource($taskManagementCommittee), 200);
        } catch (ValidationException $e) {
            return api_response(false, 'Echec de la récupération des infos de la tache', $e->errors(), 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TaskManagementCommittee $taskManagementCommittee)
    {
        try {
            $taskManagementCommittee->delete();

            return api_response(true, 'Succès de la suppression de la tache', null, 200);
        } catch (ValidationException $e) {
            return api_response(false, 'Echec de la supression de la tache', $e->errors(), 422);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskManagementCommitteeRequest $request, TaskManagementCommittee $taskManagementCommittee)
    {
        try {
            $this->task->update($taskManagementCommittee, $request->all());

            return api_response(true, "Succès de l'enregistrement de la tache", new TaskManagementCommitteeResource($taskManagementCommittee), 200);
        } catch (ValidationException $e) {
            return api_response(false, "Echec de l'enregistrement de la tache", $e->errors(), 422);
        }
    }

    public function deleteArrayTaskManagementCommittee(DeleteTaskManagementCommitteeRequest $request)
    {
        try {
            $this->task->deleteArray($request);

            return api_response(true, 'Succès de la suppression des taches', null, 200);
        } catch (ValidationException $e) {
            return api_response(false, 'Echec de la suppression des taches', $e->errors(), 422);
        }
    }

    public function updateStatusTaskManagementCommittee(UpdateStatusTaskManagementCommitteeRequest $request)
    {
        try {
            $this->task->updateStatus($request);

            return api_response(true, 'Succès de la mise à jour des taches', null, 200);
        } catch (ValidationException $e) {
            return api_response(false, 'Echec de la mise à jour des taches', $e->errors(), 422);
        }
    }

    public function generatePdfTasks(GeneratePdfManagementCommitteeRequest $request)
    {
        try {
            $data = $this->task->generatePdf($request);

            return $data;
        } catch (Throwable $th) {
            return api_error($success = false, 'Une erreur s\'est produite lors de l\'opération', ['server' => $th->getMessage()]);
        }
    }
}
