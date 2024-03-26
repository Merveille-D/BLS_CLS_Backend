<?php
namespace App\Repositories;

use App\Models\Gourvernance\BoardDirectors\Sessions\TaskSessionAdministrator;

class TaskSessionAdministratorRepository
{
    public function __construct(private TaskSessionAdministrator $task) {

    }

    /**
     * @param Request $request
     *
     * @return TaskSessionAdministrator
     */
    public function store($request) {
        $task_session_administrator = $this->task->create($request->all());
        return $task_session_administrator;
    }

    /**
     * @param Request $request
     *
     * @return TaskSessionAdministrator
     */
    public function update($request) {
        $task_session_administrator = $this->task->update($request->all());
        return $task_session_administrator;
    }
}
