<?php
namespace App\Repositories\Litigation;

use App\Concerns\Traits\Transfer\AddTransferTrait;
use App\Http\Resources\Litigation\LitigationTaskResource;
use App\Http\Resources\Transfer\TransferResource;
use App\Models\Litigation\Litigation;
use App\Models\Litigation\LitigationDocument;
use App\Models\Litigation\LitigationTask;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;

class LitigationTaskRepository
{
    use AddTransferTrait;
    public function __construct(
        private LitigationTask $task_model,
        private Litigation $litigation_model
    ) {}

    public function getList($request) {
        // dd(app($this->task_model::MODULES[$request->modele]),$request->id);
        $modele = $this->litigation_model->findOrFail($request->id);

        return LitigationTaskResource::collection(
            $modele?->tasks()
            ->orderByRaw('IF(max_deadline IS NOT NULL, 0, 1)')
            ->orderBy('max_deadline')
            ->orderBy('rank')
            ->get()
        );
    }

    public function getOne($id) {
        return new LitigationTaskResource($this->task_model->findOrFail($id));
    }

    public function add($request) {
        $task = new $this->task_model([
            'code' => 'task-'.rand(10000, 99999),
            'title' => $request->title,
            'max_deadline' => $request->deadline,
            'type' => 'task',
            'created_by' => auth()->id(),
        ]);

        $task->taskable()->associate($this->litigation_model->findOrFail($request->model_id));
        $task->save();

        return new LitigationTaskResource($task);
    }

    public function edit($request, $task_id) {
        $task = $this->task_model->findOrFail($task_id);
        if ($task->type == 'task')
            $task->title = $request->title;

        $task->max_deadline = $request->deadline;
        $task->save();

        return new LitigationTaskResource($task);
    }

    public function transfer($task, $request) {
        $task = $this->task_model->findOrFail($task);

        $this->add_transfer($task, $request['forward_title'], $request['deadline_transfer'], $request['description'], $request['collaborators']);
        return new LitigationTaskResource($task);
    }

    public function getTransferHistory($task_id, $request) {
        $task = $this->task_model->findOrFail($task_id);

        return TransferResource::collection($task->transfers);
    }

    public function delete($task_id) : bool {
        $task = $this->task_model->findOrFail($task_id);
        if ($task->status == false) {
            $task->delete();
            return true;
        }
        return false;
    }

    public function complete($task, $request) : JsonResource {
        if (/* $task->type == 'task' ||  */blank($task->form)) {
            $task->update([
                'status' => true,
                'completed_at' => now(),
                'completed_by' => auth()->id(),
            ]);
        } else {
            $litigation = $task->taskable;
            $fields = $task?->form['fields'];
            $data = [];
            foreach ($fields as $field) {

                if ($field['type'] == 'text' || $field['type'] == 'select' || $field['type'] == 'radio') {
                    $data[]  =  [$field['name'] => $request->{$field['name']}];
                }elseif ($field['type'] == 'file') {
                    $this->saveFiles($request->documents, $litigation, $task->code);
                } elseif ($field['type'] == 'date') {
                    $task->completed_at = $request->completed_at;
                }
            }

            $task->completed_by = auth()->id();
            $task->status = true;

            $litigation->extra = $data;
            $litigation->save();
            $task->save();
        }

        return new LitigationTaskResource($task->refresh());
    }

    public function saveFiles($files,Model $litigation, string $state) : array|bool {
        if (count($files)<=0)
            return [];

        foreach ($files as $key => $file_elt) {

            $file_path = storeFile($file_elt['file'], 'litigation/'.$litigation->type);

            $doc = new LitigationDocument();
            $doc->state = $state;
            // $doc->type = $litigation->type;
            $doc->file_name = $file_elt['name'];
            $doc->file_path = $file_path;

            $litigation->documents()->save($doc);
        }

        return true;

    }

}
