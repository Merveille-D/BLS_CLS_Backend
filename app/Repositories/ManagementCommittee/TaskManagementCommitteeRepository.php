<?php
namespace App\Repositories\ManagementCommittee;

use App\Concerns\Traits\PDF\GeneratePdfTrait;
use App\Concerns\Traits\Transfer\AddTransferTrait;
use App\Models\Gourvernance\ExecutiveManagement\ManagementCommittee\ManagementCommittee;
use App\Models\Gourvernance\ExecutiveManagement\ManagementCommittee\TaskManagementCommittee;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TaskManagementCommitteeRepository
{
    use GeneratePdfTrait;
    use AddTransferTrait;

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

        $request['created_by'] = Auth::user()->id;
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

        if(isset($request['forward_title'])) {
            $this->add_transfer($taskManagementCommittee, $request['forward_title'], $request['deadline_transfer'], $request['description'], $request['collaborators']);
        }
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

            $updateData = ['status' => $data['status']];
            if ($data['status']) {
                $updateData['completed_by'] = Auth::user()->id;
            }

            $taskManagementCommittee->update($updateData);
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

    public function generatePdf($request){

        $management_committee = ManagementCommittee::find($request['management_committe_id']);


        $tasks = TaskManagementCommittee::where('management_committee_id', $management_committee->id)
                                    ->whereIn('type', $request['type'])
                                    ->get();
        $title = $request['type'] == 'checklist' ? 'Checklist' : 'Procedure';

        dd($tasks);

        $filename = Str::slug($title .''. $management_committee->libelle). '_'.date('YmdHis') . '.pdf';

        $pdf =  $this->generateFromView( 'pdf.management_committee.checklist_and_procedure',  [
            'tasks' => $tasks,
            'management_committee' => $management_committee,
            'title' => $title,
        ], $filename);
        return $pdf;
    }
}
