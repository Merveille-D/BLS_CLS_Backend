<?php
namespace App\Repositories\SessionAdministrator;

use App\Concerns\Traits\PDF\GeneratePdfTrait;
use App\Models\Gourvernance\BoardDirectors\Sessions\SessionAdministrator;
use App\Models\Gourvernance\BoardDirectors\Sessions\TaskSessionAdministrator;
use Carbon\Carbon;

class TaskSessionAdministratorRepository
{
    use GeneratePdfTrait;

    public function __construct(private TaskSessionAdministrator $task) {

    }

    /**
     * @param Request $request
     *
     * @return TaskSessionAdministrator
     */
    public function all($request) {

        $task_session_administrators = $this->task
            ->where('session_administrator_id', $request->session_administrator_id)
            ->when(request('type') !== null, function($query) {
                $query->where('type', request('type'));
            }, function($query) {
                $query->whereNotIn('type', ['checklist', 'procedure']);
            })
            ->get();

        return $task_session_administrators;
    }

    /**
     * @param Request $request
     *
     * @return TaskSessionAdministrator
     */
    public function store($request) {
        if(!$request->has('type')) {
            $session_administrator = SessionAdministrator::find($request['session_administrator_id']);
            $sessionDate = Carbon::parse($session_administrator->session_date);
            $request['type'] = $sessionDate->isPast() ? 'post_ca' : 'pre_ca';
        }

        $task_session_administrator = $this->task->create($request->all());

        return $task_session_administrator;
    }

    /**
     * @param Request $request
     *
     * @return TaskSessionAdministrator
     */
    public function update(TaskSessionAdministrator $taskSessionAdministrator, $request) {
        $taskSessionAdministrator->update($request);
        return $taskSessionAdministrator;
    }

    /**
     * @param Request $request
     *
     * @return TaskSessionAdministrator
     */

     public function updateStatus($request) {
        foreach ($request['tasks'] as $data) {
            $taskSessionAdministrator = $this->task->findOrFail($data['id']);
            $taskSessionAdministrator->update(['status' => $data['status']]);
            $updatedTasks[] = $taskSessionAdministrator;

            if($taskSessionAdministrator->type === 'pre_ca') {
                $session_administrator = $taskSessionAdministrator->session_administrator();
                if($taskSessionAdministrator->deadline === $session_administrator->session_date) {
                    $session_administrator->update(['status' => 'post_ca']);
                }
            }
        }

        return $taskSessionAdministrator;
    }

    /**
     * @param Request $request
     *
     * @return TaskSessionAdministrator
     */
    public function deleteArray($request) {
        foreach ($request['tasks'] as $data) {
            $taskSessionAdministrator = $this->task->findOrFail($data['id']);
            $taskSessionAdministrator->delete();
        }

        return true;
    }

    public function generatePdf($request){

        $session_administrator = SessionAdministrator::find($request['session_administrator_id']);

        $meeting_type = SessionAdministrator::SESSION_MEETING_TYPES_VALUES[$session_administrator->type];

        $tasks = TaskSessionAdministrator::where('session_administrator_id', $session_administrator->id)
                                    ->whereIn('type', ['checklist', 'procedure'])
                                    ->get();

        $pdf =  $this->generateFromView( 'pdf.session_administrator.checklist_and_procedure',  [
            'tasks' => $tasks,
            'session_administrator' => $session_administrator,
            'meeting_type' => $meeting_type,
        ]);
        return $pdf;
    }
}
