<?php

namespace App\Http\Controllers\API\V1\Guarantee;

use App\Http\Controllers\Controller;
use App\Http\Requests\Guarantee\AddGuaranteeRequest;
use App\Http\Requests\Guarantee\EditGuaranteeRequest;
use App\Http\Requests\Transfer\AddTransferRequest;
use App\Models\Guarantee\Guarantee;
use App\Repositories\Guarantee\GuaranteeRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GuaranteeController extends Controller
{
    public function __construct(
        private GuaranteeRepository $guaranteeRepo
    ){}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return api_response(true, 'Guarantee retrieved successfully', $this->guaranteeRepo->getList(request()));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddGuaranteeRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = $this->guaranteeRepo->add($request);
            DB::commit();
            return api_response($success = true, 'Garantie initié avec succès', $data, 201);
        } catch (\Throwable $th) {
            DB::rollBack();
            return api_error($success = false, 'Une erreur s\'est produite lors de l\'operation', ['server' => $th->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Guarantee $guarantee)
    {
        return api_response(true, 'Guarantee retrieved successfully', $this->guaranteeRepo->getOne($guarantee));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EditGuaranteeRequest $request, Guarantee $guarantee)
    {
        try {
            DB::beginTransaction();
            $data = $this->guaranteeRepo->edit($guarantee, $request);
            DB::commit();
            return api_response($success = true, 'Garantie modifié avec succès', $data);
        } catch (\Throwable $th) {
            DB::rollBack();
            return api_error($success = false, 'Une erreur s\'est produite lors de l\'operation', ['server' => $th->getMessage()]);
        }
    }

    public function realization(Guarantee $guarantee) {
        try {
            $data = $this->guaranteeRepo->realization($guarantee);
            return api_response($success = true, 'Procédure de réalisation  éffectuée avec succès', $data);
        } catch (\Throwable $th) {
            return api_error($success = false, 'Une erreur s\'est produite lors de l\'operation', ['server' => $th->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Guarantee $guarantee)
    {
        //
    }

    /**
     * generate pdf
     */
    public function generatePdf($guarantee)
    {
        try {
            $data = $this->guaranteeRepo->generatePdf($guarantee);
            return $data;
        } catch (\Throwable $th) {
            return api_error($success = false, 'Une erreur s\'est produite lors de l\'opération', ['server' => $th->getMessage()]);
        }
    }

    /**
     * transfert dossier de surete
     */
    public function transfer(AddTransferRequest $request, $guarantee)
    {
        try {
            DB::beginTransaction();
            $data = $this->guaranteeRepo->transfer($request, $guarantee);
            DB::commit();
            return api_response($success = true, 'La garantie a été transférée avec succès', $data, 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return api_error($success = false, 'Une erreur s\'est produite lors de l\'operation', ['server' => $th->getMessage()]);
        }
    }
}
