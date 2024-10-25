<?php

namespace App\Repositories\Recovery;

use App\Concerns\Traits\Transfer\AddTransferTrait;
use App\Http\Resources\Recovery\RecoveryTaskResource;
use App\Http\Resources\Transfer\TransferResource;
use App\Models\Guarantee\GuaranteeDocument;
use App\Models\Recovery\Recovery;
use App\Models\Recovery\RecoveryTask;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;

class RecoveryTaskRepository
{
    use AddTransferTrait;

    public function __construct(
        private RecoveryTask $task_model,
        private RecoveryRepository $recoveryRepo,
        private Recovery $recovery_model,
    ) {}

    public function getList($request)
    {
        $modele = $this->recovery_model->find($request->id);

        if (! $modele) {
            return [];
        }

        return RecoveryTaskResource::collection(
            $modele?->tasks
        );
    }

    public function getOne($id)
    {
        return new RecoveryTaskResource($this->task_model->findOrFail($id));
    }

    public function add($request)
    {
        $task = new $this->task_model([
            'code' => 'task-' . rand(10000, 99999),
            'title' => $request->title,
            'max_deadline' => $request->deadline,
            'type' => 'task',
            'created_by' => auth()->id(),
        ]);

        $task->taskable()->associate($this->recovery_model->findOrFail($request->model_id));
        $task->save();

        return new RecoveryTaskResource($task);
    }

    public function edit($request, $task_id)
    {
        $task = $this->task_model->findOrFail($task_id);
        if ($task->type == 'task') {
            $task->title = $request->title;
        }

        $task->max_deadline = $request->deadline;
        $task->save();

        return new RecoveryTaskResource($task);
    }

    public function transfer($task, $request)
    {
        $task = $this->task_model->findOrFail($task);

        $this->addTransfer($task, $request['forward_title'], $request['deadline_transfer'], $request['description'], $request['collaborators']);

        return new RecoveryTaskResource($task);
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
        if (/* $task->type == 'task' ||  */ blank($task->form)) {
            $task->update([
                'status' => true,
                'completed_at' => now(),
                'completed_by' => auth()->id(),
            ]);
        } else {
            $this->recoveryRepo->updateProcess($request, $task->taskable);
        }

        return new RecoveryTaskResource($task->refresh());
    }

    public function saveNextTasks($current_task, $radio_field)
    {
        $steps = $current_task?->step?->children()->where('parent_response', $radio_field)->get();

        foreach ($steps as $key => $step) {
            $task = new GuaranteeTask;
            $task->code = $step->code;
            $task->title = $step->title;
            $task->rank = $step->rank;
            $task->type = $step->step_type;
            $task->max_deadline = null;
            $task->created_by = auth()->id();

            $task->taskable()->associate($current_task->taskable);
            $task->save();
        }

    }

    public function saveFiles($files, Model $guarantee, string $state): array|bool
    {
        if (count($files) <= 0) {
            return [];
        }

        foreach ($files as $key => $file_elt) {

            $file_path = storeFile($file_elt['file'], 'guarantee/' . $guarantee->type);

            $doc = new GuaranteeDocument;
            $doc->state = $state;
            $doc->type = $guarantee->type;
            $doc->file_name = $file_elt['name'];
            $doc->file_path = $file_path;

            $guarantee->documents()->save($doc);
        }

        return true;

    }
}
