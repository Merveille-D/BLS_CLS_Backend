<?php

namespace App\Http\Controllers\API\V1\Evaluation;

use App\Http\Controllers\Controller;
use App\Http\Requests\PerformanceIndicator\ListPerformanceIndicatorRequest;
use App\Models\Evaluation\Collaborator;
use App\Models\Evaluation\PerformanceIndicator;
use App\Repositories\Evaluation\PerformanceIndicatorRepository;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PerformanceIndicatorController extends Controller
{
    public function __construct(private PerformanceIndicatorRepository $performanceIndicator) {}

    /**
     * Display a listing of the resource.
     */
    public function index(ListPerformanceIndicatorRequest $request)
    {
        $performance_indicators = PerformanceIndicator::where('position_id', $request->position_id)->get()->load('position');

        $performance_indicators = PerformanceIndicator::when(request('position_id') !== null, function ($query) {
            $query->where('position_id', request('position_id'));
        })
            ->when(request('collaborator_id') !== null, function ($query) {
                $collaborator = Collaborator::find(request('collaborator_id'));
                $query->where('position_id', $collaborator->position_id);
            })
            ->get()->load('position');

        return api_response(true, 'Liste des indicateurs de performance', $performance_indicators, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $performanceIndicator = $this->performanceIndicator->store($request->all());
            $performanceIndicator->position = $performanceIndicator->position;

            return api_response(true, "Succès de l'enregistrement de l'indicateur de performance", $performanceIndicator, 200);
        } catch (ValidationException $e) {
            return api_response(false, "Echec de l'enregistrement de l'indicateur de performance", $e->errors(), 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(PerformanceIndicator $performanceIndicator)
    {
        try {
            return api_response(true, "Infos de l'indicateur de performance", $performanceIndicator, 200);
        } catch (ValidationException $e) {
            return api_response(false, "Echec de la récupération des infos de l'indicateur de performance", $e->errors(), 422);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PerformanceIndicator $performanceIndicator)
    {
        try {
            $performanceIndicator = $this->performanceIndicator->update($performanceIndicator, $request->all());
            $performanceIndicator->position = $performanceIndicator->position;

            return api_response(true, "Mis à jour de l'indicateur de performance", $performanceIndicator, 200);
        } catch (ValidationException $e) {

            return api_response(false, 'Echec de la mise à jour', $e->errors(), 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PerformanceIndicator $performanceIndicator)
    {
        try {
            $performanceIndicator->delete();

            return api_response(true, "Succès de la suppression de l'indicateur de performance", null, 200);
        } catch (ValidationException $e) {
            return api_response(false, "Echec de la supression de l'indicateur de performance", $e->errors(), 422);
        }
    }
}
