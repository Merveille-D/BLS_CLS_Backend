<?php

namespace App\Http\Controllers\API\V1\Evaluation;

use App\Http\Controllers\Controller;
use App\Http\Requests\Collaborator\ListCollaboratorRequest;
use App\Http\Requests\Collaborator\StoreCollaboratorRequest;
use App\Http\Requests\Collaborator\UpdateCollaboratorRequest;
use App\Models\Evaluation\Collaborator;
use App\Repositories\Evaluation\CollaboratorRepository;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CollaboratorController extends Controller
{

    public function __construct(private CollaboratorRepository $collaborator) {

    }

    /**
     * Display a listing of the resource.
     */
    public function index(ListCollaboratorRequest $request)
    {
        $collaborators = Collaborator::where('position_id', $request->position_id)->get()->load('position');
        return api_response(true, "Liste des Collaborateurs", $collaborators, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCollaboratorRequest $request)
    {
        try {
            $collaborator = $this->collaborator->store($request->all());
            return api_response(true, "Succès de l'enregistrement du collaborateur", $collaborator, 200);
        }catch (ValidationException $e) {
                return api_response(false, "Echec de l'enregistrement du collaborateur", $e->errors(), 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Collaborator $collaborator)
    {
        try {
            return api_response(true, "Infos du collaborateur", $collaborator, 200);
        }catch( ValidationException $e ) {
            return api_response(false, "Echec de la récupération des infos du collaborateur", $e->errors(), 422);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCollaboratorRequest $request, Collaborator $collaborator)
    {
        try {
            $this->collaborator->update($collaborator, $request->all());
            return api_response(true, "Mis à jour du collaborateur", $collaborator, 200);
        } catch (ValidationException $e) {

            return api_response(false, "Echec de la mise à jour", $e->errors(), 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Collaborator $collaborator)
    {
        try {
            $collaborator->delete();
            return api_response(true, "Succès de la suppression du collaborateur", null, 200);
        }catch (ValidationException $e) {
                return api_response(false, "Echec de la supression du collaborateur", $e->errors(), 422);
        }
    }
}
