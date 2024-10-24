<?php

namespace App\Http\Controllers\API\V1\Guarantee;

use App\Http\Controllers\Controller;
use App\Http\Requests\Hypothec\AddTaskRequest;
use App\Http\Requests\Hypothec\CompleteTaskRequest;
use App\Http\Requests\Hypothec\EditTaskRequest;
use App\Http\Requests\Hypothec\UpdateTaskRequest;
use App\Models\Guarantee\HypothecTask;
use App\Repositories\Guarantee\HypothecTaskRepository;
use Illuminate\Support\Facades\DB;
use Throwable;

class ConvHypothecTaskController extends Controller
{
    public function __construct(
        private HypothecTaskRepository $taskRepo,
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        request()->merge(['modele' => 'conv_hypothec']);

        return api_response(true, 'Liste des taches recuperée', $this->taskRepo->getList(request()));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddTaskRequest $request)
    {
        try {
            $task = $this->taskRepo->add($request);

            return api_response(true, 'Tache ajoutée avec succès', $task);
        } catch (Throwable $th) {
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
    public function update(EditTaskRequest $request, $task_id)
    {
        try {
            $task = $this->taskRepo->edit($request, $task_id);

            return api_response(true, 'Tache modifiée avec succès', $task);
        } catch (Throwable $th) {
            return api_error(false, 'Une erreur s\'est produite lors de l\'operation', ['server' => $th->getMessage()]);
        }
    }

    public function complete(CompleteTaskRequest $request, HypothecTask $task)
    {
        try {
            DB::beginTransaction();
            $task = $this->taskRepo->complete($task, $request);
            DB::commit();

            return api_response(true, 'Transfert éffectué avec succès', $task);
        } catch (Throwable $th) {
            DB::rollBack();

            return api_error(false, 'Une erreur s\'est produite lors de l\'operation', ['server' => $th->getMessage()]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function transfer(UpdateTaskRequest $request, $task)
    {
        try {
            DB::beginTransaction();
            $task = $this->taskRepo->transfer($task, $request);
            DB::commit();

            return api_response(true, 'Transfert éffectué avec succès', $task);
        } catch (Throwable $th) {
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
