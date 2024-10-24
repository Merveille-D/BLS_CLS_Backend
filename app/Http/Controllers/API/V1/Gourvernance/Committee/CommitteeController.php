<?php

namespace App\Http\Controllers\API\V1\Gourvernance\Committee;

use App\Http\Controllers\Controller;
use App\Http\Requests\Committee\ListCommitteeRequest;
use App\Http\Requests\Committee\StoreCommitteeRequest;
use App\Http\Requests\Committee\UpdateCommitteeRequest;
use App\Http\Resources\Committee\ExecutiveCommitteeResource;
use App\Models\Gourvernance\Committee;
use App\Repositories\Committee\CommitteeRepository;
use Illuminate\Validation\ValidationException;

class CommitteeController extends Controller
{
    public function __construct(private CommitteeRepository $committee) {}

    /**
     * Display a listing of the resource.
     */
    public function index(ListCommitteeRequest $request)
    {
        $committees = $this->committee->list($request->validated());

        return api_response(true, 'Liste des comités', $committees, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCommitteeRequest $request)
    {
        try {
            $committee = $this->committee->store($request->all());

            return api_response(true, "Succès de l'enregistrement du comité", $committee, 200);
        } catch (ValidationException $e) {
            return api_response(false, "Echec de l'enregistrement du comité", $e->errors(), 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Committee $committee)
    {
        try {
            return api_response(true, 'Infos du comité', $committee, 200);
        } catch (ValidationException $e) {
            return api_response(false, 'Echec de la récupération des infos du comité', $e->errors(), 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function listExecutives(Committee $committee)
    {
        try {
            $executive_committees = $this->committee->listExecutives($committee);

            return api_response(true, 'Liste des cadres du comité', ExecutiveCommitteeResource::collection($executive_committees), 200);
        } catch (ValidationException $e) {
            return api_response(false, 'Echec de la récupération des infos du comité', $e->errors(), 422);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCommitteeRequest $request, Committee $committee)
    {
        try {
            $this->committee->update($committee, $request->all());

            return api_response(true, 'Mis à jour du texte avec succès', $committee, 200);
        } catch (ValidationException $e) {

            return api_response(false, 'Echec de la mise à jour', $e->errors(), 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Committee $committee)
    {
        try {
            $committee->delete();

            return api_response(true, 'Succès de la suppression du comité', null, 200);
        } catch (ValidationException $e) {
            return api_response(false, 'Echec de la supression du comité', $e->errors(), 422);
        }
    }
}
