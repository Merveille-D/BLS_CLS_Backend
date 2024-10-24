<?php

namespace App\Http\Controllers\API\V1\Contract;

use App\Http\Controllers\Controller;
use App\Http\Requests\Contract\ListTaskContractRequest;
use App\Http\Requests\TaskContract\DeleteTaskContractRequest;
use App\Http\Requests\TaskContract\StoreTaskContractRequest;
use App\Http\Requests\TaskContract\UpdateStatusTaskContractRequest;
use App\Http\Requests\TaskContract\UpdateTaskContractRequest;
use App\Models\Contract\Task;
use App\Repositories\Contract\TaskContractRepository;
use Illuminate\Validation\ValidationException;

class TaskController extends Controller
{
    public function __construct(private TaskContractRepository $task) {}

    /**
     * Display a listing of the resource.
     */
    public function index(ListTaskContractRequest $request)
    {
        $task_contracts = $this->task->all($request)->map(function ($task) {

            $task->transfers = $task->transfers->map(function ($transfer) {
                $transfer->sender = $transfer->sender;
                $transfer->collaborators = $transfer->collaborators;

                return $transfer;
            });

            return $task;
        });

        return api_response(true, 'Liste des taches du contrat', $task_contracts, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskContractRequest $request)
    {
        try {
            $task_contract = $this->task->store($request);

            return api_response(true, "Succès de l'enregistrement de la tache", $task_contract, 200);
        } catch (ValidationException $e) {
            return api_response(false, "Echec de l'enregistrement de la tache", $e->errors(), 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        try {
            $data = $task->toArray();
            $data['transfers'] = $task->transfers->map(function ($transfer) {
                $transfer->sender = $transfer->sender;
                $transfer->collaborators = $transfer->collaborators;

                return $transfer;
            });

            return api_response(true, 'Information de la tache', $data, 200);
        } catch (ValidationException $e) {
            return api_response(false, 'Echec de la récupération des infos de la tache', $e->errors(), 422);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskContractRequest $request, Task $task)
    {
        try {
            $this->task->update($task, $request->all());

            $data = $task->toArray();
            $data['transfers'] = $task->transfers->map(function ($transfer) {
                $transfer->sender = $transfer->sender;
                $transfer->collaborators = $transfer->collaborators;

                return $transfer;
            });

            //
            return api_response(true, 'Succès de la mise à jour de la tache', $data, 200);
        } catch (ValidationException $e) {
            return api_response(false, 'Echec de la mise à jour de la tache', $e->errors(), 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        try {
            $task->delete();

            return api_response(true, 'Succès de la suppression de la tache', null, 200);
        } catch (ValidationException $e) {
            return api_response(false, 'Echec de la supression de la tache', $e->errors(), 422);
        }
    }

    public function deleteArrayTaskContract(DeleteTaskContractRequest $request)
    {
        try {
            $this->task->deleteArray($request);

            return api_response(true, 'Succès de la suppression des taches', null, 200);
        } catch (ValidationException $e) {
            return api_response(false, 'Echec de la suppression des taches', $e->errors(), 422);
        }
    }

    public function updateStatusTaskContract(UpdateStatusTaskContractRequest $request)
    {
        try {
            $this->task->updateStatus($request);

            return api_response(true, 'Succès de la mise à jour des taches', null, 200);
        } catch (ValidationException $e) {
            return api_response(false, 'Echec de la mise à jour des taches', $e->errors(), 422);
        }
    }
}
