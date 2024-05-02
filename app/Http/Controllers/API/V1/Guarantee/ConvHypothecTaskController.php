<?php

namespace App\Http\Controllers\API\V1\Guarantee;

use App\Http\Controllers\Controller;
use App\Http\Requests\Hypothec\AddTaskRequest;
use App\Http\Requests\Hypothec\UpdateTaskRequest;
use App\Http\Resources\Guarantee\ConvHypothecStepResource;
use App\Models\Guarantee\HypothecTask;
use App\Repositories\Guarantee\HypothecTaskRepository;
use Illuminate\Http\Request;

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
    public function update(UpdateTaskRequest $request, HypothecTask $task)
    {
        try {
            $task = $this->taskRepo->edit($task, $request);

            return api_response(true, 'Tache modifiée avec succès', new ConvHypothecStepResource($task));
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
