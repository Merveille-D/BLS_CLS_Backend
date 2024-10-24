<?php

namespace App\Repositories\Shareholder;

use App\Concerns\Traits\Transfer\AddTransferTrait;
use App\Models\Shareholder\ActionTransferDocument;
use App\Models\Shareholder\TaskActionTransfer;
use Illuminate\Support\Facades\Auth;

class TaskActionTransferRepository
{
    use AddTransferTrait;

    public function __construct(private TaskActionTransfer $taskActionTransfer) {}

    /**
     * @param  Request  $request
     * @return TaskActionTransfer
     */
    public function all($request)
    {

        $task_action_transfers = $this->taskActionTransfer->where('action_transfer_id', $request->action_transfer_id)->get()->map(function ($taskActionTransfer) {
            $taskActionTransfer->form = $taskActionTransfer->form;
            $taskActionTransfer->deadline = $taskActionTransfer->date ?? $taskActionTransfer->deadline;

            return $taskActionTransfer;
        });

        return $task_action_transfers;
    }

    /**
     * @param  Request  $request
     * @return TaskActionTransfer
     */
    public function update(TaskActionTransfer $taskActionTransfer, $request)
    {

        if (isset($request['documents'])) {
            foreach ($request['documents'] as $item) {

                $fileUpload = new ActionTransferDocument;

                $fileUpload->name = $item['name'];
                $fileUpload->file = uploadFile($item['file'], 'action_transfer_documents');

                $taskActionTransfer->fileUploads()->save($fileUpload);
            }
        }

        if (isset($request['asked_agrement'])) {
            $request['asked_agrement'] = ($request['asked_agrement'] === 'yes') ? true : false;
        }

        if (isset($request['forward_title'])) {
            $this->add_transfer($taskActionTransfer, $request['forward_title'], $request['deadline_transfer'], $request['description'], $request['collaborators']);
        } else {
            $request['status'] = true;
            $request['completed_by'] = Auth::user()->id;
            $taskActionTransfer->update($request);

            if ($this->checkLastTask($taskActionTransfer)) {

                if ($request['asked_agrement']) {
                    $taskActionTransfer->actionTransfer->update(['status' => 'validated']);
                } else {
                    $taskActionTransfer->actionTransfer->update(['status' => 'rejected']);
                }

            }
        }

        return $taskActionTransfer;
    }

    /**
     * @param  Request  $request
     * @return TaskActionTransfer
     */
    public function getCurrentTask($request)
    {

        $task_action_transfer = $this->taskActionTransfer->where('action_transfer_id', $request->action_transfer_id)->where('status', false)->first();

        return $task_action_transfer;
    }

    private function checkLastTask($task_action_transfer)
    {

        $last_task_action_transfer = $this->taskActionTransfer->where('action_transfer_id', $task_action_transfer->action_transfer_id)->orderBy('id', 'desc')->first();

        return $task_action_transfer->id === $last_task_action_transfer->id ? true : false;
    }
}
