<?php

namespace App\Http\Controllers\API\V1\Evaluation;

use App\Http\Controllers\Controller;
use App\Http\Requests\EvaluationPeriod\StoreEvaluationPeriodRequest;
use App\Http\Requests\EvaluationPeriod\UpdateEvaluationPeriodRequest;
use App\Models\Evaluation\EvaluationPeriod;
use App\Repositories\Evaluation\EvaluationPeriodRepository;
use Illuminate\Validation\ValidationException;

class EvaluationPeriodController extends Controller
{

    public function __construct(private EvaluationPeriodRepository $evaluation_period) {

    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $evaluation_periods = EvaluationPeriod::all();
        return api_response(true, "Liste des périodes d'evaluation", $evaluation_periods, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEvaluationPeriodRequest $request)
    {
        try {
            $evaluation_period = $this->evaluation_period->store($request);
            return api_response(true, "Succès de l'enregistrement de la période", $evaluation_period, 200);
        }catch (ValidationException $e) {
                return api_response(false, "Echec de l'enregistrement", $e->errors(), 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(EvaluationPeriod $evaluation_period)
    {
        try {
            return api_response(true, "Infos de la période", $evaluation_period, 200);
        }catch( ValidationException $e ) {
            return api_response(false, "Echec de la récupération des infos ", $e->errors(), 422);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEvaluationPeriodRequest $request, EvaluationPeriod $evaluation_period)
    {
        try {
            $this->evaluation_period->update($evaluation_period, $request->all());
            return api_response(true, "Mis à jour de la période d'evaluation avec succès", $evaluation_period, 200);
        } catch (ValidationException $e) {

            return api_response(false, "Echec de la mise à jour", $e->errors(), 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EvaluationPeriod $evaluation_period)
    {
        try {
            $evaluation_period->delete();
            return api_response(true, "Succès de la suppression ", null, 200);
        }catch (ValidationException $e) {
                return api_response(false, "Echec de la supression ", $e->errors(), 422);
        }
    }
}
