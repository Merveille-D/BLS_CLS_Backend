<?php

namespace App\Http\Controllers\API\V1\Guarantee;

use App\Http\Controllers\Controller;
use App\Http\Requests\Hypothec\InitConvHypothecRequest;
use App\Http\Requests\Hypothec\UpdateProcessRequest;
use App\Models\Guarantee\ConventionnalHypothecs\ConventionnalHypothec;
use App\Models\Guarantee\ConvHypothec;
use App\Repositories\Guarantee\ConvHypothecRepository;
use Essa\APIToolKit\Api\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ConvHypothecController extends Controller
{
    use ApiResponse;
    public function __construct(private ConvHypothecRepository $hypothecRepo) {}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return api_response(true, 'Liste de tous les hypotheques conventionnelles', $data = $this->hypothecRepo->getConvHypothecs(request()));
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
    public function updateProcess(UpdateProcessRequest $request, ConvHypothec $convHypo)
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

    public function realization($convHypo) {
        try {
            DB::beginTransaction();
            $data = $this->hypothecRepo->realization($convHypo);
            DB::commit();
            return api_response($success = true, 'Procédure de réalisation  éffectuée avec succès', $data);
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
        return api_response(true, 'Hypothèque conventionnelle recuperée', $data = $this->hypothecRepo->getConvHypothecById($id));
    }

    /**
     * Display the all steps for an hypothec.
     */
    public function showSteps(string $id)
    {
        return api_response(true, 'Etapes recuperées', $data = $this->hypothecRepo->getHypthecSteps($id, request()));
    }

    /**
     * Display the specified resource.
     */
    public function showOneStep(string $hypothec_id, string $step_id)
    {
        return api_response(true, 'Etape recuperée', $data = $this->hypothecRepo->getOneStep($hypothec_id, $step_id));
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
