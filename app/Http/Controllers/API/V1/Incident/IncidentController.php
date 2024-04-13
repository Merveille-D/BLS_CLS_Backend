<?php

namespace App\Http\Controllers\API\V1\Incident;

use App\Http\Controllers\Controller;
use App\Http\Requests\Incident\ListIncidentRequest;
use App\Http\Requests\Incident\StoreIncidentRequest;
use App\Http\Requests\Incident\UpdateIncidentRequest;
use App\Models\Incident\Incident;
use App\Repositories\Incident\IncidentRepository;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class IncidentController extends Controller
{
    public function __construct(private IncidentRepository $incident) {

    }

    /**
     * Display a listing of the resource.
     */
    public function index(ListIncidentRequest $request)
    {
        $incidents = Incident::with('authorIncident')->when(request('type') !== null, function($query) {
            $query->where('type', request('type'));
        })->get()->map(function ($incident) {
            $incident->category = $incident->category;
            $incident->current_task = $incident->current_task;
            return $incident;
        });

        return api_response(true, "Liste des donnée de l'incident", $incidents, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreIncidentRequest $request)
    {
        try {
            $incident = $this->incident->store($request);

            $incident->load('authorIncident');
            $data = $incident->toArray();
            $data['category'] = $incident->category;
            $data['current_task'] = $incident->current_task;

            return api_response(true, "Succès de l'enregistrement dans l'incident", $data, 200);
        }catch (ValidationException $e) {
                return api_response(false, "Echec de l'enregistrement dans l'incident", $e->errors(), 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Incident $incident)
    {
        try {
            $incident->load('authorIncident');
            $data = $incident->toArray();
            $data['category'] = $incident->category;
            $data['current_task'] = $incident->current_task;

            return api_response(true, "Infos de l'incident", $data, 200);
        }catch( ValidationException $e ) {
            return api_response(false, "Echec de la récupération des infos de l'incident", $e->errors(), 422);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateIncidentRequest $request, Incident $incident)
    {
        try {
            $this->incident->update($incident, $request->all());

            $incident->load('authorIncident');
            $data = $incident->toArray();
            $data['category'] = $incident->category;

            return api_response(true, "Mis à jour du texte avec succès", $data, 200);
        } catch (ValidationException $e) {

            return api_response(false, "Echec de la mise à jour", $e->errors(), 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Incident $incident)
    {
        try {
            $incident->delete();
            return api_response(true, "Succès de la suppression de l'incident", null, 200);
        }catch (ValidationException $e) {
                return api_response(false, "Echec de la supression de l'incident", $e->errors(), 422);
        }
    }
}
