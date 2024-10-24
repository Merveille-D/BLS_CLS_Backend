<?php

namespace App\Repositories\Guarantee;

use App\Concerns\Traits\Transfer\AddTransferTrait;
use App\Http\Resources\Guarantee\HypothecTaskResource;
use App\Http\Resources\Transfer\TransferResource;
use App\Models\Guarantee\HypothecTask;
use Illuminate\Http\Resources\Json\JsonResource;

class HypothecTaskRepository
{
    use AddTransferTrait;

    public function __construct(
        private HypothecTask $task_model,
        private ConvHypothecRepository $convRepo,
    ) {}

    public function getList($request)
    {
        $modele = app($this->task_model::MODULES[$request->modele])?->find($request->id);

        if (! $modele) {
            return [];
        }
        $tasks = $modele?->tasks()
            ->orderByRaw('IF(max_deadline IS NOT NULL, 0, 1)')
            ->orderBy('max_deadline')
            ->orderBy('rank')
            ->get();

        return HypothecTaskResource::collection($tasks);
    }

    public function getOne($id)
    {
        return new HypothecTaskResource($this->task_model->findOrFail($id));
    }

    public function add($request)
    {
        $task = new $this->task_model([
            'code' => 'task-' . rand(1000, 9999),
            'title' => $request->title,
            'status' => false,
            'max_deadline' => $request->deadline,
            'type' => 'task',
            'created_by' => auth()->id(),
        ]);

        $task->taskable()->associate($this->getModeleByType($request->modele, $request->model_id));
        $task->save();

        return new HypothecTaskResource($task);
    }

    public function getModeleByType($type, $model_id)
    {
        return $modele = app($this->task_model::MODULES[$type])?->find($model_id);
    }

    public function edit($request, $task_id)
    {
        $task = $this->task_model->findOrFail($task_id);
        if ($task->type == 'task') {
            $task->title = $request->title;
        }

        $task->max_deadline = $request->deadline;
        $task->save();

        return new HypothecTaskResource($task);
    }

    public function transfer($task, $request)
    {
        $task = $this->task_model->findOrFail($task);

        $this->add_transfer($task, $request['forward_title'], $request['deadline_transfer'], $request['description'], $request['collaborators']);

        return new HypothecTaskResource($task);
    }

    public function getTransferHistory($task_id, $request)
    {
        $task = $this->task_model->findOrFail($task_id);

        return TransferResource::collection($task->transfers);
    }

    public function delete($task_id)
    {
        $task = $this->task_model->findOrFail($task_id);
        if ($task->type == 'task') {
            $task->delete();
        }
    }

    public function complete($task, $request): JsonResource
    {
        $convHypo = $task->taskable;

        if ($task->type == 'task') {
            $task->update([
                'status' => true,
                'completed_at' => now(),
                'completed_by' => auth()->id(),
            ]);
        } else {
            $this->convRepo->updateProcess($request, $convHypo);
        }

        return new HypothecTaskResource($task->refresh());
    }
}
