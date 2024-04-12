<?php
namespace App\Repositories\ActionTransfer;

use App\Models\Shareholder\ActionTransfer;

class ActionTransferRepository
{
    public function __construct(private ActionTransfer $ActionTransfer) {

    }

    /**
     * @param Request $request
     *
     * @return ActionTransfer
     */
    public function store($request) {

        $ActionTransfer = $this->ActionTransfer->create($request->all());
        return $ActionTransfer;
    }

    /**
     * @param Request $request
     *
     * @return ActionTransfer
     */
    public function update(ActionTransfer $ActionTransfer, $request) {

        $ActionTransfer = $this->ActionTransfer->create($request->all());
        return $ActionTransfer;
    }


}
