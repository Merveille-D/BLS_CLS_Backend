<?php

namespace App\Http\Controllers\API\V1\Evaluation;

use App\Http\Controllers\Controller;
use App\Http\Requests\Notation\ListNotationRequest;
use App\Http\Requests\Notation\StoreUpdateNotationRequest;
use App\Models\Evaluation\Notation;
use App\Repositories\Evaluation\NotationRepository;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class NotationController extends Controller
{
    public function __construct(private NotationRepository $notation) {

    }

    public function all() {
        $notations = Notation::get()->map(function ($notation) {
            $notation->indicators = $notation->indicators;
            $notation->collaborator = $notation->collaborator;
            return $notation;
        });

        return api_response(true, "Evaluation du collaborateur", $notations, 200);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(ListNotationRequest $request)
    {
        $notations = Notation::where('collaborator_id', request('collaborator_id')
        )->first()->map(function ($notation) {
            $notation->indicators = $notation->indicators;
            $notation->collaborator = $notation->collaborator;
            return $notation;
        });

        return api_response(true, "Evaluation du collaborateur", $notations, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUpdateNotationRequest $request)
    {
        try {
            $this->notation->store($request);
            return api_response(true, "Succès de l'enregistrement de l'evaluation", null, 200);
        }catch (ValidationException $e) {
                return api_response(false, "Echec de l'enregistrement de l'evaluation", $e->errors(), 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Notation $notation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Notation $notation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Notation $notation)
    {
        //
    }
}
