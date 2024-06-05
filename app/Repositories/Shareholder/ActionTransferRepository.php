<?php
namespace App\Repositories\Shareholder;

use App\Models\Gourvernance\GourvernanceDocument;
use App\Models\Shareholder\ActionTransfer;
use App\Models\Shareholder\Shareholder;
use Illuminate\Support\Facades\Auth;

class ActionTransferRepository
{
    public function __construct(private ActionTransfer $action_transfer) {

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

            $request['status'] = 'pending';
            $action_transfer = $this->action_transfer->create($request);

            // Create Task
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

}
