<?php
namespace App\Repositories\Shareholder;

use App\Models\Gourvernance\GourvernanceDocument;
use App\Models\Shareholder\ActionTransfer;
use App\Models\Shareholder\Shareholder;

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

        $action_transfer = $this->action_transfer->create($request->all());

        $owner = Shareholder::find($request['owner_id']);
        $owner->update([
            'actions_no_encumbered' => $owner->actions_no_encumbered - $request['count_actions']
        ]);

        $buyer = Shareholder::find($request['buyer_id']);
        $buyer->update([
            'actions_no_encumbered' => $buyer->actions_no_encumbered + $request['count_actions']
        ]);

        if (is_null($request['buyer_id'])) {

            // $fileUpload = new GourvernanceDocument([
            //     'name' => getFileName($request['ask_agrement']),
            //     'file' => uploadFile($request['ask_agrement'], 'action_transfer_documents'),
            //     'status' => 'pending'
            // ]);

            // $action_transfer->fileUploads()->save($fileUpload);
        }

        // $action_transfer->update($request->all());

        return $action_transfer;
    }

    /**
     * @param Request $request
     *
     * @return ActionTransfer
     */
    public function update(ActionTransfer $action_transfer, $request) {

        // if($request['response_agrement']) {
        //     $fileUpload = new GourvernanceDocument([
        //         'name' => getFileName($request['file_agrement_ca']),
        //         'file' => uploadFile($request['file_agrement_ca'], 'action_transfer_documents'),
        //         'status' => $action_transfer->status
        //     ]);

        //     $action_transfer->fileUploads()->save($fileUpload);
        //     $request['status'] = 'accepted';
        // }else {
        //     $request['status'] = 'rejected';
        // }

        // $action_transfer = $this->action_transfer->update($request->all());
        // return $action_transfer;
    }

}
