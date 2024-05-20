<?php

namespace App\Http\Controllers\API\V1\Gourvernance\Shareholder;

use App\Http\Controllers\Controller;
use App\Http\Requests\ActionTransfer\StoreActionTransferRequest;
use App\Http\Requests\ActionTransfer\UpdateActionTransferRequest;
use App\Models\Shareholder\ActionTransfer;
use App\Repositories\Shareholder\ActionTransferRepository;
use Illuminate\Validation\ValidationException;

class ActionTransferController extends Controller
{

    public function __construct(private ActionTransferRepository $action_transfer) {

    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $action_transfers = ActionTransfer::get()->map(function ($action_transfer) {

            $action_transfer->owner = $action_transfer->owner;
            $action_transfer->buyer = $action_transfer->buyer;
            return $action_transfer;
        });
        return api_response(true, "Historique des transfert", $action_transfers, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreActionTransferRequest $request)
    {
        try {
            $action_transfer = $this->action_transfer->store($request);
            return api_response(true, "Succès de l'enregistrement du transfert", $action_transfer, 200);
        }catch (ValidationException $e) {
                return api_response(false, "Echec de l'enregistrement", $e->errors(), 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ActionTransfer $action_transfer)
    {
        try {
            return api_response(true, "Infos du transfert d'action", $action_transfer, 200);
        }catch( ValidationException $e ) {
            return api_response(false, "Echec de la récupération des infos du transfer", $e->errors(), 422);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateActionTransferRequest $request, ActionTransfer $action_transfer)
    {
        // try {
        //     $this->action_transfer->update($action_transfer, $request->all());
        //     return api_response(true, "Mis à jour du du transfert", $action_transfer, 200);
        // } catch (ValidationException $e) {

        //     return api_response(false, "Echec de la mise à jour", $e->errors(), 422);
        // }
    }
}
