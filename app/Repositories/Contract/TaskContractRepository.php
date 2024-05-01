<?php
namespace App\Repositories\Contract;

use App\Models\Contract\Task;
use App\Concerns\Traits\Transfer\AddTransferTrait;
use Carbon\Carbon;

class TaskContractRepository
{
    public function __construct(private Task $task) {

    }

    /**
     * @param Request $request
     *
     * @return Task
     */
    public function all($request) {

        $tasks = $this->task->where('contract_id', $request->contract_id)->get();
        return $tasks;
    }

    /**
     * @param Request $request
     *
     * @return Task
     */
    public function store($request) {

        $task = $this->task->create($request->all());
        return $task;
    }

    /**
     * @param Request $request
     *
     * @return Task
     */
    public function update(Task $task, $request) {

        $task->update($request);


        $transferExist = $task->transfers()->exists();

        if ($transferExist) {

            $this->add_transfer($task, $request['title'], $request['deadline'], $request['description'], $request['collaborators']);
        }

        return $task;
    }

    /**
     * @param Request $request
     *
     * @return Task
     */

    public function updateStatus($request) {
        foreach ($request['tasks'] as $data) {
            $task = $this->task->findOrFail($data['id']);
            $task->update(['status' => $data['status']]);
            $updatedTasks[] = $task;
        }

        return $task;
    }

    /**
     * @param Request $request
     *
     * @return Task
     */
    public function deleteArray($request) {
        foreach ($request['tasks'] as $data) {
            $task = $this->task->findOrFail($data['id']);
            $task->delete();
        }

        return true;
    }

}
