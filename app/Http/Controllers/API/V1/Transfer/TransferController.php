<?php

namespace App\Http\Controllers\API\V1\Transfer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Transfer\CompleteTransferRequest;
use App\Models\Transfer\Transfer;
use App\Repositories\Transfer\TransferRepository;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TransferController extends Controller
{
    public function __construct(private TransferRepository $contract) {

    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Transfer $transfer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transfer $transfer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transfer $transfer)
    {
        //
    }

    public function completeTransfer(CompleteTransferRequest $request)
    {
        try {
            $transfer = Transfer::find($request->transfer_id);

            $this->contract->completeTransfer($request->all(), $transfer);

            return api_response(true, "Mis à jour du transfert avec succès", $transfer, 200);
        } catch (ValidationException $e) {

            return api_response(false, "Echec de la mise à jour du transfer", $e->errors(), 422);
        }
    }
}
