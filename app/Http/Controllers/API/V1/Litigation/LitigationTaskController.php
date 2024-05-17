<?php

namespace App\Http\Controllers\API\V1\Litigation;

use App\Http\Controllers\Controller;
use App\Http\Requests\Guarantee\AddLitigationTaskRequest;
use App\Http\Requests\Litigation\CompleteTaskRequest;
use App\Http\Requests\Transfer\AddTransferRequest;
use App\Http\Resources\Task\TaskResource;
use App\Models\Contract\Task;
use App\Models\Litigation\LitigationTask;
use App\Models\ModuleTask;
use App\Repositories\Litigation\LitigationTaskRepository;
use App\Repositories\Task\TaskRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LitigationTaskController extends Controller
{
    public function __construct(
        private LitigationTaskRepository $taskRepo,
    ) {

    }
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
    public function store(AddLitigationTaskRequest $request)
    {
        try {
            DB::beginTransaction();
            $task = $this->taskRepo->add($request);
            DB::commit();
            return api_response(true, 'Tache ajoutée avec succès', $task);
        } catch (\Throwable $th) {
            DB::rollBack();
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
     * complete task
     *
     * @param  array $request
     * @param  mixed $task
     * @return void
     */
    public function complete(CompleteTaskRequest $request, LitigationTask $task) {
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
    public function destroy($task_id)
    {
        $this->taskRepo->delete($task_id);

        return api_response(true, 'Tache supprimée avec succès');
    }
}
