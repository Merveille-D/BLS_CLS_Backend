<?php
namespace App\Repositories\Contract;

use App\Models\Contract\Task;
use App\Concerns\Traits\Transfer\AddTransferTrait;
use App\Models\Contract\ContractDocument;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class TaskContractRepository
{
    use AddTransferTrait;

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

        $request['created_by'] = Auth::user()->id;
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

        if(isset($request['documents'])) {
            foreach($request['documents'] as $item) {

                $fileUpload = new ContractDocument();

                $fileUpload->name = $item['name'];
                $fileUpload->file = uploadFile($item['file'], 'contract_documents');

                $task->fileUploads()->save($fileUpload);
            }
        }

        if(isset($request['forward_title'])) {
            $this->add_transfer($task, $request['forward_title'], $request['deadline_transfer'], $request['description'], $request['collaborators']);
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
