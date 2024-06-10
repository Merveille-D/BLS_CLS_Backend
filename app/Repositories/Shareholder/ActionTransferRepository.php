<?php
namespace App\Repositories\Shareholder;

use App\Models\Shareholder\ActionTransfer;
use App\Models\Shareholder\Shareholder;
use App\Models\Shareholder\TaskActionTransfer;
use App\Repositories\Tier\TierRepository;
use Illuminate\Support\Facades\Auth;

class ActionTransferRepository
{
    public function __construct(
        private ActionTransfer $action_transfer,
        public TierRepository $tier,
        public ShareholderRepository $shareholder,
        ) {

    }

    /**
     * @param Request $request
     *
     * @return ActionTransfer
     */
    public function store($request) {

        $request['created_by'] = Auth::user()->id;

        if($request['type'] == 'shareholder') {

            $action_transfer = $this->action_transfer->create($request);

            $owner = Shareholder::find($request['owner_id']);
            $owner->update([
                'actions_no_encumbered' => $owner->actions_no_encumbered - $request['count_actions'],
                'actions_number' => $owner->actions_number - $request['count_actions'],
            ]);

            $buyer = Shareholder::find($request['buyer_id']);
            $buyer->update([
                'actions_no_encumbered' => $buyer->actions_no_encumbered + $request['count_actions'],
                'actions_number' => $buyer->actions_number + $request['count_actions'],
            ]);

        }else {

            $request['tier_id'] = (isset($request['name'])) ? $this->tier->store($request)->id : $request['buyer_id'];
            $request['status'] = 'pending';

            unset($request['buyer_id']);

            $action_transfer = $this->action_transfer->create($request);

            // Create Task
            $this->createTasks($action_transfer);
        }

        return $action_transfer;
    }

    /**
     * @param Request $request
     *
     * @return ActionTransfer
     */
    public function update(ActionTransfer $action_transfer, $request) {

        //
    }

    private function createTasks($action_transfer) {

        $previousDeadline = null;

        foreach (TaskActionTransfer::TASKS as $key => $task) {

            $deadline = $previousDeadline ? $previousDeadline->addDays($task['delay']) : $action_transfer->created_at->addDays($task['delay']);

            TaskActionTransfer::create([
                'title' => $task['title'],
                'code' => $key,
                'action_transfer_id' => $action_transfer->id,
                'deadline' => $deadline,
                'created_by' => Auth::user()->id,
            ]);

            $previousDeadline = $deadline;
        }

        return true;
    }

    public function approvedActionTransfer($request) {

        $action_transfer = ActionTransfer::find($request['action_transfer_id']);

        $tier = $action_transfer->tier;

        $request['name'] = $tier->name;
        $request['actions_encumbered'] = $action_transfer->count_actions;
        $request['actions_no_encumbered'] = 0;

        $shareholder = $this->shareholder->store($request);

        $action_transfer->update([
            'status' => 'approved',
            'buyer_id' => $shareholder->id,
            'tier_id' => null,
        ]);

        $tier->delete();

        return $action_transfer;

    }
}
