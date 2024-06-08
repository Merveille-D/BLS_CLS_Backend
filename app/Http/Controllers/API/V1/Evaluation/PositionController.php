<?php

namespace App\Http\Controllers\API\V1\Evaluation;

use App\Http\Controllers\Controller;
use App\Http\Requests\Position\StorePositionRequest;
use App\Http\Requests\Position\UpdatePositionRequest;
use App\Models\Evaluation\Position;
use App\Repositories\Evaluation\PositionRepository;
use Illuminate\Validation\ValidationException;

class PositionController extends Controller
{

    public function __construct(private PositionRepository $position) {

    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $positions = Position::all()->load('collaborators', 'indicators');
        return api_response(true, "Liste des positions", $positions, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePositionRequest $request)
    {
        try {
            $position = $this->position->store($request->all());
            return api_response(true, "Succès de l'enregistrement de la position", $position, 200);
        }catch (ValidationException $e) {
                return api_response(false, "Echec de l'enregistrement de la position", $e->errors(), 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Position $position)
    {
        try {

            return api_response(true, "Infos de la position", $position, 200);
        }catch( ValidationException $e ) {
            return api_response(false, "Echec de la récupération de la position", $e->errors(), 422);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePositionRequest $request, Position $position)
    {
        try {

            $this->position->update($position, $request->all());
            return api_response(true, "Mis à jour de la position avec succès", $position, 200);
        } catch (ValidationException $e) {

            return api_response(false, "Echec de la mise à jour", $e->errors(), 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Position $position)
    {
        try {
            $position->delete();
            return api_response(true, "Succès de la suppression de la position", null, 200);
        }catch (ValidationException $e) {
                return api_response(false, "Echec de la supression de la position", $e->errors(), 422);
        }
    }
}
