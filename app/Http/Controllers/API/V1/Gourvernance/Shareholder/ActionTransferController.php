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
        $action_transfers = ActionTransfer::orderBy('created_at', 'desc')->get()->map(function ($action_transfer) {
            $action_transfer->owner= $action_transfer->owner;
            $action_transfer->buyer = $action_transfer->buyer ?? $action_transfer->tier;

            $action_transfer->makeHidden('owner_id', 'buyer_id', 'tier_id', 'created_at', 'updated_at');
            return $action_transfer;
        });
        return api_response(true, "Liste des transferts d'actions", $action_transfers, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreActionTransferRequest $request)
    {
        try {
            $action_transfer = $this->action_transfer->store($request->all());
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
            $data = $action_transfer->makeHidden('owner_id', 'buyer_id', 'tier_id', 'created_at', 'updated_at', '')->toArray();
            $data['owner'] = $action_transfer->owner;
            $data['buyer'] = $action_transfer->buyer ?? $action_transfer->tier;
            $data['category'] = $action_transfer->category;
            $data['current_task'] = $action_transfer->current_task;
            $data['files'] = $action_transfer->files;

            return api_response(true, "Infos du transfert d'action", $data, 200);
        }catch( ValidationException $e ) {
            return api_response(false, "Echec de la récupération des infos du transfer", $e->errors(), 422);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateActionTransferRequest $request, ActionTransfer $action_transfer)
    {
        //
    }
}
