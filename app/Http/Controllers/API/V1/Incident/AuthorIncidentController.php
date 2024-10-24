<?php

namespace App\Http\Controllers\API\V1\Incident;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthorIncident\StoreAuthorIncidentRequest;
use App\Http\Requests\AuthorIncident\UpdateAuthorIncidentRequest;
use App\Models\Incident\AuthorIncident;
use App\Repositories\Incident\AuthorIncidentRepository;
use Illuminate\Validation\ValidationException;

class AuthorIncidentController extends Controller
{
    public function __construct(private AuthorIncidentRepository $authorIncident) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $author_incidents = AuthorIncident::all();

        return api_response(true, "Liste des auteurs d'incidents", $author_incidents, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAuthorIncidentRequest $request)
    {
        try {
            $authorIncident = $this->authorIncident->store($request->all());

            return api_response(true, "Succès de l'enregistrement de l'auteur", $authorIncident, 200);
        } catch (ValidationException $e) {
            return api_response(false, "Echec de l'enregistrement de l'auteur", $e->errors(), 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(AuthorIncident $authorIncident)
    {
        try {
            return api_response(true, "Infos de l'auteur ", $authorIncident, 200);
        } catch (ValidationException $e) {
            return api_response(false, "Echec de la récupération des infos de l'auteur", $e->errors(), 422);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAuthorIncidentRequest $request, AuthorIncident $authorIncident)
    {
        try {
            $this->authorIncident->update($authorIncident, $request->all());

            return api_response(true, "Mis à jour de l'auteur avec succès", $authorIncident, 200);
        } catch (ValidationException $e) {

            return api_response(false, 'Echec de la mise à jour', $e->errors(), 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AuthorIncident $authorIncident)
    {
        try {
            $authorIncident->delete();

            return api_response(true, "Succès de la suppression de l'auteur ", null, 200);
        } catch (ValidationException $e) {
            return api_response(false, "Echec de la supression de l'auteur", $e->errors(), 422);
        }
    }
}
