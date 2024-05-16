<?php
namespace App\Repositories\Guarantee;

use App\Concerns\Traits\Transfer\AddTransferTrait;
use App\Http\Resources\Guarantee\ConvHypothecStepResource;
use App\Http\Resources\Guarantee\GuaranteeTaskResource;
use App\Http\Resources\Transfer\TransferResource;
use App\Models\Guarantee\ConvHypothecStep;
use App\Models\Guarantee\GuaranteeDocument;
use App\Models\Guarantee\HypothecTask;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;

class GuaranteeTaskRepository
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

        return GuaranteeTaskResource::collection(
            $modele?->tasks()
            ->orderByRaw('IF(max_deadline IS NOT NULL, 0, 1)')
            ->orderBy('max_deadline')
            ->orderBy('rank')
            ->get()
        );
    }

    public function getOne($id) {
        return new GuaranteeTaskResource($this->task_model->findOrFail($id));
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

        return new GuaranteeTaskResource($task);
    }

    public function getModeleByType($type, $model_id) {
        return $modele = app($this->task_model::MODULES[$type])?->find($model_id);
    }

    public function edit($request, $task_id) {
        $task = $this->task_model->findOrFail($task_id);
        if ($task->type == 'task')
            $task->title = $request->title;

        $task->max_deadline = $request->deadline;
        $task->save();

        return new GuaranteeTaskResource($task);
    }

    public function transfer($task, $request) {
        $task = $this->task_model->findOrFail($task);

        $this->add_transfer($task, $request['forward_title'], $request['deadline_transfer'], $request['description'], $request['collaborators']);
        return new GuaranteeTaskResource($task);
    }

    public function getTransferHistory($task_id, $request) {
        $task = $this->task_model->findOrFail($task_id);

        return TransferResource::collection($task->transfers);
    }

    public function delete($task_id) {
        $task = $this->task_model->findOrFail($task_id);
        if ($task->type == 'task') {
            $task->delete();
        }
    }

    public function complete($task, $request) : JsonResource {
        if (/* $task->type == 'task' ||  */blank($task->form)) {
            $task->update([
                'status' => true,
                'completed_at' => now(),
                'completed_by' => auth()->id(),
            ]);
        } else {
            $guarantee = $task->taskable;

            if ($request->documents)
                $this->saveFiles($request->documents, $guarantee, $task->code);

            if ($request->completed_at)
                $task->completed_at = $request->completed_at;

            $task->completed_by = auth()->id();
            $task->status = true;
            $guarantee->status = $task->code;

            if ($request->is_paid)
                $guarantee->is_paid = $request->is_paid;
            if ($request->contract_type)
                $guarantee->contract_type = $request->contract_type;

            $guarantee->save();
            $task->save();
        }

        return new GuaranteeTaskResource($task->refresh());
    }

    public function saveFiles($files,Model $guarantee, string $state) : array|bool {
        if (count($files)<=0)
            return [];

        foreach ($files as $key => $file_elt) {

            $file_path = storeFile($file_elt['file'], 'guarantee/'.$guarantee->type);

            $doc = new GuaranteeDocument();
            $doc->state = $state;
            $doc->type = $guarantee->type;
            $doc->file_name = $file_elt['name'];
            $doc->file_path = $file_path;

            $guarantee->documents()->save($doc);
        }

        return true;

    }

}
