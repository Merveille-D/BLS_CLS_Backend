<?php
namespace App\Repositories\Guarantee;

use App\Concerns\Traits\Transfer\AddTransferTrait;
use App\Http\Resources\Guarantee\ConvHypothecStepResource;
use App\Models\Guarantee\ConvHypothecStep;
use App\Models\Guarantee\HypothecTask;

class HypothecTaskRepository
{
    use AddTransferTrait;
    public function __construct(
        private HypothecTask $task_model,
    ) {}


    function add($request) {
        $task = $this->task_model->create([
            'code' => 'task-'.rand(1000, 9999), // 'T-1234
            'name' => $request->name,
            'max_deadline' => $request->deadline,
            'type' => 'task',
            'created_by' => auth()->id(),
            'hypothec_id' => $request->hypothec_id,
        ]);

        return new ConvHypothecStepResource($task);
    }

    public function edit($task, $request) {
        // $task->update([
        //     'name' => $request->name,
        //     'max_deadline' => $request->deadline,
        // ]);
        $this->add_transfer($task, $request['forward_title'], $request['deadline_transfer'], $request['description'], $request['collaborators']);
        return new ConvHypothecStepResource($task);
    }

    public function delete($task) {
        $task->delete();
    }


}
