<?php
namespace App\Repositories\Guarantee;

use App\Concerns\Traits\Transfer\AddTransferTrait;
use App\Http\Resources\Guarantee\ConvHypothecStepResource;
use App\Http\Resources\Guarantee\HypothecTaskResource;
use App\Http\Resources\Transfer\TransferResource;
use App\Models\Guarantee\ConvHypothecStep;
use App\Models\Guarantee\HypothecTask;

class HypothecTaskRepository
{
    use AddTransferTrait;
    public function __construct(
        private HypothecTask $task_model,
    ) {}

    public function getList($request) {
        // dd(app($this->task_model::MODULES[$request->modele]),$request->id);
        $modele = app($this->task_model::MODULES[$request->modele])?->find($request->id);
        if(!$modele) {
            return array();
        }

        return HypothecTaskResource::collection($modele?->tasks);
    }

    public function getOne($id) {
        return new HypothecTaskResource($this->task_model->findOrFail($id));
    }

    public function add($request) {
        $task = new $this->task_model([
            'code' => 'task-'.rand(1000, 9999),
            'title' => $request->title,
            'max_deadline' => $request->deadline,
            'type' => 'task',
            'created_by' => auth()->id(),
        ]);

        $task->taskable()->associate($this->getModeleByType($request->modele, $request->model_id));
        $task->save();

        return new HypothecTaskResource($task);
    }

    public function getModeleByType($type, $model_id) {
        return $modele = app($this->task_model::MODULES[$type])?->find($model_id);
    }

    public function edit($request, $task_id) {
        $task = $this->task_model->findOrFail($task_id);
        $task->update([
            'title' => $request->title,
            'max_deadline' => $request->deadline,
        ]);
        // $this->add_transfer($task, $request['forward_title'], $request['deadline_transfer'], $request['description'], $request['collaborators']);
        return new HypothecTaskResource($task);
    }

    public function transfer($task, $request) {
        $task = $this->task_model->findOrFail($task);

        $this->add_transfer($task, $request['forward_title'], $request['deadline_transfer'], $request['description'], $request['collaborators']);
        return new HypothecTaskResource($task);
    }

    public function getTransferHistory($task_id, $request) {
        $task = $this->task_model->findOrFail($task_id);

        return TransferResource::collection($task->transfers);
    }

    public function delete($task_id) {
        $task = $this->task_model->findOrFail($task_id);
        $task->delete();
    }

}
