<?php

namespace App\Http\Controllers\API\V1\TASK;

use App\Http\Controllers\Controller;
use App\Http\Requests\Hypothec\AddTaskRequest;
use App\Http\Requests\Hypothec\EditTaskRequest;
use App\Http\Requests\Hypothec\UpdateTaskRequest;
use App\Http\Resources\Guarantee\ConvHypothecStepResource;
use App\Models\Guarantee\HypothecTask;
use App\Repositories\Task\TaskRepository;
use Illuminate\Http\Request;

class TaskController extends Controller
{

    public function __construct(
        private TaskRepository $taskRepo,
    ) {}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return api_response(true, 'Liste des taches recuperée', $this->taskRepo->getList(request()));
        $hypothec_id = request('hypothec_id');

        return ConvHypothecStepResource::collection(HypothecTask::where('hypothec_id', $hypothec_id)->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddTaskRequest $request)
    {
        try {
            $task = $this->taskRepo->add($request);

            return api_response(true, 'Tache ajoutée avec succès', new ConvHypothecStepResource($task));
        } catch (\Throwable $th) {
            return api_error(false, 'Une erreur s\'est produite lors de l\'operation', ['server' => $th->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(HypothecTask $task)
    {
        return api_response(true, 'Tache recuperée', new ConvHypothecStepResource($task));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EditTaskRequest $request, HypothecTask $task)
    {
        try {
            $task = $this->taskRepo->edit($task, $request);

            return api_response(true, 'Tache modifiée avec succès', new ConvHypothecStepResource($task));
        } catch (\Throwable $th) {
            return api_error(false, 'Une erreur s\'est produite lors de l\'operation', ['server' => $th->getMessage()]);
        }
    }
    /**
     * Update the specified resource in storage.
     */
    public function transfer(UpdateTaskRequest $request, $task)
    {
        try {
            $task = $this->taskRepo->transfer($task, $request);

            return api_response(true, 'Transfert éffectué avec succès', new ConvHypothecStepResource($task));
        } catch (\Throwable $th) {
            return api_error(false, 'Une erreur s\'est produite lors de l\'operation', ['server' => $th->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HypothecTask $convHypothecStep)
    {
        //
    }
}
