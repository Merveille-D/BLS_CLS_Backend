<?php

namespace App\Http\Controllers\API\V1\Guarantee;

use App\Http\Controllers\Controller;
use App\Http\Requests\Hypothec\InitConvHypothecRequest;
use App\Http\Requests\Hypothec\UpdateProcessRequest;
use App\Models\Guarantee\ConventionnalHypothecs\ConventionnalHypothec;
use App\Repositories\Guarantee\ConvHypothecRepository;
use Essa\APIToolKit\Api\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ConvHypothecController extends Controller
{
    use ApiResponse;
    public function __construct(private ConvHypothecRepository $hypothecRepo) {

    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return api_response(true, 'Liste de tous les hypotheques conventionnelles', $data = $this->hypothecRepo->getConvHypothecs());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(InitConvHypothecRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = $this->hypothecRepo->initFormalizationProcess($request, null);
            DB::commit();
            return api_response($success = true, 'Hypotheque conventionnelle initié avec succès', $data);
        } catch (\Throwable $th) {
            DB::rollBack();
            return api_response($success = false, 'Une erreur s\'est produite lors de l\'operation', ['error' => $th->getMessage()]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function updateProcess(UpdateProcessRequest $request, ConventionnalHypothec $convHypo)
    {
        try {
            DB::beginTransaction();
            $data = $this->hypothecRepo->updateProcess($request, $convHypo);
            DB::commit();
            return api_response($success = true, 'Hypotheque conventionnelle mise à jour avec succès', $data);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th->getMessage());
            return api_error($success = false, 'Une erreur s\'est produite lors de l\'operation', ['server' => $th->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return api_response(true, 'Hypothèque conventionnelle recuperé', $data = $this->hypothecRepo->getConvHypothecById($id));
    }

    /**
     * Display the specified resource.
     */
    public function showSteps(string $id)
    {
        return api_response(true, 'Etapes recuperé', $data = $this->hypothecRepo->getHypthecSteps($id, request()));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
