<?php

namespace App\Http\Controllers\API\V1\Litigation;

use App\Http\Controllers\Controller;
use App\Http\Requests\Transfer\AddTransferRequest;
use App\Http\Resources\Task\TaskResource;
use App\Models\Contract\Task;
use App\Models\ModuleTask;
use App\Repositories\Task\TaskRepository;
use Illuminate\Http\Request;

class LitigationTaskController extends Controller
{
    public function __construct(
        private TaskRepository $taskRepo,
    ) {

    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        request()->merge(['modele' => 'litigation']);

        return api_response(true, 'Liste des taches recuperée', $this->taskRepo->getList(request()));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            request()->merge(['modele' => 'litigation']);

            $task = $this->taskRepo->add($request);

            return api_response(true, 'Tache ajoutée avec succès', $task);
        } catch (\Throwable $th) {
            return api_error(false, 'Une erreur s\'est produite lors de l\'operation', ['server' => $th->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $task_id)
    {
        return api_response(true, 'Tache recuperée', $this->taskRepo->getOne($task_id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $task_id)
    {
        try {
            request()->merge(['modele' => 'litigation']);

            $task = $this->taskRepo->edit($request, $task_id);

            return api_response(true, 'Tache ajoutée avec succès', $task);
        } catch (\Throwable $th) {
            return api_error(false, 'Une erreur s\'est produite lors de l\'operation', ['server' => $th->getMessage()]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function transfer(AddTransferRequest $request, $task)
    {
        try {
            $task = $this->taskRepo->transfer($task, $request);

            return api_response(true, 'Transfert éffectué avec succès', new TaskResource($task));
        } catch (\Throwable $th) {
            return api_error(false, 'Une erreur s\'est produite lors de l\'operation', ['server' => $th->getMessage()]);
        }
    }

    public function transferHistory($task_id) {
        return api_response(true, 'Liste des transferts recuperée', $this->taskRepo->getTransferHistory($task_id, request()));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($task_id)
    {
        $this->taskRepo->delete($task_id);

        return api_response(true, 'Tache supprimée avec succès');
    }
}
