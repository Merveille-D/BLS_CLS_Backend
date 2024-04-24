<?php
namespace App\Repositories\Contract;

use App\Models\Contract\Task;
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

        if(checkDealine($task->deadline)) {
            $task->alerts()->save(triggerAlert("RAPPEL | CONTRAT", $task->libelle));
        }

        return $task;
    }

    /**
     * @param Request $request
     *
     * @return Task
     */
    public function update(Task $task, $request) {

        $task->update($request);
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
