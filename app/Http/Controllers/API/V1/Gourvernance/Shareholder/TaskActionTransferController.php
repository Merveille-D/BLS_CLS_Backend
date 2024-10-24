<?php

namespace App\Http\Controllers\API\V1\Gourvernance\Shareholder;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskActionTransfer\GetCurrentTaskActionTransferRequest;
use App\Http\Requests\TaskActionTransfer\ListTaskActionTransferRequest;
use App\Http\Requests\TaskActionTransfer\UpdateTaskActionTransferRequest;
use App\Models\Shareholder\TaskActionTransfer;
use App\Repositories\Shareholder\TaskActionTransferRepository;
use Illuminate\Validation\ValidationException;

class TaskActionTransferController extends Controller
{
    public function __construct(private TaskActionTransferRepository $taskActionTransfer) {}

    /**
     * Display a listing of the resource.
     */
    public function index(ListTaskActionTransferRequest $request)
    {
        $task_action_transfers = $this->taskActionTransfer->all($request);

        return api_response(true, "Liste des taches du transfert d'action ", $task_action_transfers, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(TaskActionTransfer $taskActionTransfer)
    {
        try {
            return api_response(true, 'Information de la tache', $taskActionTransfer, 200);
        } catch (ValidationException $e) {
            return api_response(false, 'Echec de la récupération des infos de la tache', $e->errors(), 422);
        }
    }

    public function completeTaskActionTransfer(UpdateTaskActionTransferRequest $request)
    {
        $taskActionTransfer = TaskActionTransfer::find($request->input('task_action_transfer_id'));

        $current_task_action_transfer = TaskActionTransfer::where('action_transfer_id', $taskActionTransfer->action_transfer_id)->where('status', false)->first();
        if ($current_task_action_transfer->id != $taskActionTransfer->id) {
            return api_response(false, "Ce n'est pas la tache suivante à modifier", null, 422);
        }

        try {
            $this->taskActionTransfer->update($taskActionTransfer, $request->all());

            $data = $taskActionTransfer->toArray();
            $data['form'] = $taskActionTransfer->form;

            return api_response(true, "Succès de l'enregistrement de la tache", $data, 200);
        } catch (ValidationException $e) {
            return api_response(false, "Echec de l'enregistrement de la tache", $e->errors(), 422);
        }
    }

    public function getCurrentTaskActionTransfer(GetCurrentTaskActionTransferRequest $request)
    {
        $task_action_transfer = $this->taskActionTransfer->getCurrentTask($request);

        return api_response(true, "Liste des taches du transfert d'action ", $task_action_transfer, 200);
    }
}
