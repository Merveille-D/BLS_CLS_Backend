<?php
namespace App\Repositories\Guarantee;

use App\Concerns\Traits\Transfer\AddTransferTrait;
use App\Http\Resources\Guarantee\ConvHypothecStepResource;
use App\Http\Resources\Guarantee\GuaranteeTaskResource;
use App\Http\Resources\Transfer\TransferResource;
use App\Models\Guarantee\ConvHypothecStep;
use App\Models\Guarantee\GuaranteeDocument;
use App\Models\Guarantee\GuaranteeTask;
use App\Models\Guarantee\HypothecTask;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;

class GuaranteeTaskRepository
{
    use AddTransferTrait;
    public function __construct(
        private GuaranteeTask $task_model,
        private GuaranteeRepository $guaranteeRepo
    ) {}

    public function getList($request) {
        // dd(app($this->task_model::MODULES[$request->modele]),$request->id);
        $modele = app($this->task_model::MODULES[$request->modele])?->find($request->id);

        if(!$modele) {
            return array();
        }

        $tasks = GuaranteeTaskResource::collection(
            $modele?->tasks()
            ->defaultOrder()
            ->get()
        );

        return $tasks;
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

            $fields = $task?->form['fields'];
            $data = [];
            $radio_field = null;
            foreach ($fields as $field) {

                if ($field['type'] == 'text' || $field['type'] == 'select') {
                    $data[]  =  [$field['name'] => $request->{$field['name']}];
                }elseif ($field['type'] == 'file') {
                    $this->saveFiles($request->documents, $guarantee, $task->code);
                } elseif ($field['type'] == 'date') {
                    if ($field['name'] == 'completed_at')
                        $task->completed_at = $request->completed_at;
                    else
                        $data[]  =  [$field['name'] => $request->{$field['name']}];
                }elseif ($field['type'] == 'radio') {
                    $radio_field = $request->{$field['name']};
                    $data[]  =  [$field['name'] => $request->{$field['name']} == 'yes' ? true : false];
                }
            }

            $task->completed_by = auth()->id();
            // $task->status = true;
            $guarantee->status = $task->code;

            if ($request->is_paid)
                $guarantee->is_paid = $request->is_paid;
            if ($request->contract_type)
                $guarantee->contract_type = $request->contract_type;

            $guarantee->extra = $data;

            $guarantee->save();

            $this->saveNextTasks($task, $radio_field);
            $this->guaranteeRepo->updateTaskState($guarantee);
            $this->updatePhaseState($guarantee);

        }

        return new GuaranteeTaskResource($task->refresh());
    }

    public function saveNextTasks($current_task, $radio_field) {
        $steps = $current_task?->step?->children()->where('parent_response', $radio_field)->get();
        foreach ($steps as $key => $step) {
            $task = new GuaranteeTask();
            $task->code = $step->code;
            $task->title = $step->title;
            $task->step_id = $step->id;
            $task->rank = $step->rank;
            $task->type = $step->step_type;
            $task->max_deadline = null;
            $task->created_by = auth()->id();

            $task->taskable()->associate($current_task->taskable);
            $task->save();
        }

    }

    // function that change phase to formalized or realized when all tasks for the phase are completed
    public function updatePhaseState($guarantee) {
        $current_phase = $guarantee->phase;
        $tasks = $guarantee->tasks()->whereType($current_phase)->where('status', false)->get();
        // dd($tasks);
        if ($tasks->count() == 0) {
            $guarantee->phase = $current_phase == 'formalization' ? 'formalized' : 'realized';
            $guarantee->save();
        }
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
