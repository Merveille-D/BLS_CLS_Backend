<?php
namespace App\Repositories\ManagementCommittee;

use App\Models\Gourvernance\ExecutiveManagement\ManagementCommittee\ManagementCommittee;
use App\Models\Gourvernance\ExecutiveManagement\ManagementCommittee\TaskManagementCommittee;
use Carbon\Carbon;

class TaskManagementCommitteeRepository
{
    public function __construct(private TaskManagementCommittee $task) {

    }

    /**
     * @param Request $request
     *
     * @return TaskManagementCommittee
     */
    public function all($request) {

        $task_management_committees = $this->task
            ->where('management_committee_id', $request->management_committee_id)
            ->when(request('type') !== null, function($query) {
                $query->where('type', request('type'));
            }, function($query) {
                $query->whereNotIn('type', ['checklist', 'procedure']);
            })
            ->get();

        return $task_management_committees;
    }

    /**
     * @param Request $request
     *
     * @return TaskManagementCommittee
     */
    public function store($request) {
        if(!$request->has('type')) {
            $management_committee = ManagementCommittee::find($request['management_committee_id']);
            $sessionDate = Carbon::parse($management_committee->session_date);
            $request['type'] = $sessionDate->isPast() ? 'post_cd' : 'pre_cd';
        }

        $task_management_committee = $this->task->create($request->all());
        return $task_management_committee;
    }

    /**
     * @param Request $request
     *
     * @return TaskManagementCommittee
     */
    public function update(TaskManagementCommittee $taskManagementCommittee, $request) {
        $taskManagementCommittee->update($request);
        return $taskManagementCommittee;
    }

    /**
     * @param Request $request
     *
     * @return TaskManagementCommittee
     */

     public function updateStatus($request) {
        foreach ($request['tasks'] as $data) {
            $taskManagementCommittee = $this->task->findOrFail($data['id']);
            $taskManagementCommittee->update(['status' => $data['status']]);
            $updatedTasks[] = $taskManagementCommittee;

            if($taskManagementCommittee->type === 'pre_cd') {
                $management_committee = $taskManagementCommittee->management_committee();
                if($taskManagementCommittee->deadline === $management_committee->session_date) {
                    $management_committee->update(['status' => 'post_cd']);
                }
            }
        }

        return $taskManagementCommittee;
    }

    /**
     * @param Request $request
     *
     * @return TaskManagementCommittee
     */
    public function deleteArray($request) {
        foreach ($request['tasks'] as $data) {
            $taskManagementCommittee = $this->task->findOrFail($data['id']);
            $taskManagementCommittee->delete();
        }

        return true;
    }
}
