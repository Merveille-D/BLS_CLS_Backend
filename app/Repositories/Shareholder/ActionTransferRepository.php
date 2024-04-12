<?php
namespace App\Repositories\ActionTransfer;

use App\Models\Shareholder\ActionTransfer;

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

        $action_transfer = $this->ActionTransfer->create($request->all());
        return $action_transfer;
    }

    /**
     * @param Request $request
     *
     * @return ActionTransfer
     */
    public function update(ActionTransfer $action_transfer, $request) {

        $action_transfer = $this->ActionTransfer->create($request->all());
        return $action_transfer;
    }

}
