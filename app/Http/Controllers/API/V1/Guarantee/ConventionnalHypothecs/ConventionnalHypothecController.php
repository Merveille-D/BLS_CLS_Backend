<?php

namespace App\Http\Controllers\API\V1\Guarantee\ConventionnalHypothecs;

use App\Http\Controllers\Controller;
use App\Http\Requests\Hypothec\InitConvHypothecRequest;
use App\Http\Requests\Hypothec\UpdateProcessRequest;
use App\Models\Guarantee\ConventionnalHypothecs\ConventionnalHypothec;
use App\Repositories\ConvHypothecRepository;
use Essa\APIToolKit\Api\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ConventionnalHypothecController extends Controller
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
            $data = $this->hypothecRepo->initFormalizationProcess($request, null);

            return api_response($success = true, 'Hypotheque conventionnelle initié avec succès', $data);
        } catch (\Throwable $th) {
            return api_response($success = false, 'Une erreur s\'est produite lors de l\'operation', ['error' => $th->getMessage()]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function updateProcess(UpdateProcessRequest $request, ConventionnalHypothec $convHypo)
    {
        try {
            $data = $this->hypothecRepo->updateProcess($request, $convHypo);

            return api_response($success = true, 'Hypotheque conventionnelle mise à jour avec succès', $data);
        } catch (\Throwable $th) {
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
