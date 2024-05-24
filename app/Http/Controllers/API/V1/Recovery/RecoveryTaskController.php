<?php

namespace App\Http\Controllers\API\V1\Recovery;

use App\Http\Controllers\Controller;
use App\Http\Requests\Recovery\AddRecoveryTaskRequest;
use App\Http\Requests\Recovery\CompleteTaskRequest;
use App\Models\Recovery\RecoveryTask;
use App\Repositories\Recovery\RecoveryTaskRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RecoveryTaskController extends Controller
{
    public function __construct(
        private RecoveryTaskRepository $taskRepo,
    ) {}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return api_response(true, 'Liste des taches recuperée', $this->taskRepo->getList(request()));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddRecoveryTaskRequest $request)
    {
        try {
            $task = $this->taskRepo->add($request);

            return api_response(true, 'Tache ajoutée avec succès', $task, 201);
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
            $task = $this->taskRepo->edit($request, $task_id);

            return api_response(true, 'Tache modifiée avec succès', $task);
        } catch (\Throwable $th) {
            return api_error(false, 'Une erreur s\'est produite lors de l\'operation', ['server' => $th->getMessage()]);
        }
    }
    /**
     * Update the specified resource in storage.
     */
    public function transfer(CompleteTaskRequest $request, $task)
    {
        try {
            DB::beginTransaction();
            $task = $this->taskRepo->transfer($task, $request);
            DB::commit();
            return api_response(true, 'Transfert éffectué avec succès', $task);
        } catch (\Throwable $th) {
            DB::rollBack();
            return api_error(false, 'Une erreur s\'est produite lors de l\'operation', ['server' => $th->getMessage()]);
        }
    }

    /**
     * complete task
     *
     * @param  array $request
     * @param  mixed $task
     * @return void
     */
    public function complete(CompleteTaskRequest $request, RecoveryTask $task) {
        try {
            DB::beginTransaction();
            $task = $this->taskRepo->complete($task, $request);
            DB::commit();
            return api_response(true, 'Tâche complétée avec succès', $task);
        } catch (\Throwable $th) {
            DB::rollBack();
            return api_error(false, 'Une erreur s\'est produite lors de l\'operation', ['server' => $th->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $task_id)
    {
        $this->taskRepo->delete($task_id);

        return api_response(true, 'Tache supprimée avec succès');
    }
}
