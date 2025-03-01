<?php

namespace App\Http\Controllers\API\V1\Gourvernance\ExecutiveManagement\Directors;

use App\Http\Controllers\Controller;
use App\Http\Requests\Committee\ToggleExecutiveCommitteeRequest;
use App\Http\Requests\Director\AddDirectorRequest;
use App\Http\Requests\Director\RenewMandateDirectorRequest;
use App\Http\Requests\Director\UpdateDirectorRequest;
use App\Models\Gourvernance\ExecutiveManagement\Directors\Director;
use App\Repositories\ManagementCommittee\DirectorRepository;
use Illuminate\Validation\ValidationException;
use Throwable;

class DirectorController extends Controller
{
    public function __construct(private DirectorRepository $director) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $directors = Director::get()->map(function ($director) {
            $director->mandates = $director->mandates;

            return $director;
        });

        return api_response(true, 'Liste des Directeurs', $directors, 201);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddDirectorRequest $request)
    {
        $director = $this->director->add($request);

        $data = $director->toArray();
        $data['mandates'] = $director->mandates;

        return api_response(true, 'Directeur ajouté avec succès', $data, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Director $director)
    {
        try {
            $data = $director->toArray();
            $data['mandates'] = $director->mandates;

            return api_response(true, 'Infos du directeur', $data, 200);
        } catch (ValidationException $e) {
            return api_response(false, 'Echec de la récupération des infos du directeur', $e->errors(), 422);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDirectorRequest $request, Director $director)
    {
        try {
            $this->director->update($director, $request->all());

            $data = $director->toArray();
            $data['mandates'] = $director->mandates;

            return api_response(true, 'Mis à jour du directeur avec succès', $data, 200);
        } catch (ValidationException $e) {

            return api_response(false, 'Echec de la mise à jour', $e->errors(), 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Director $director)
    {
        try {
            $director->delete();

            return api_response(true, 'Succès de la suppression du directeur', null, 200);
        } catch (ValidationException $e) {
            return api_response(false, 'Echec de la supression du directeur', $e->errors(), 422);
        }
    }

    public function toggleExecutiveCommittee(ToggleExecutiveCommitteeRequest $request, Director $director)
    {
        try {
            $committee = $this->director->toggle($director, $request->validated());

            return api_response(true, 'Succès du toggle du cadre', 200);
        } catch (ValidationException $e) {
            return api_response(false, 'Echec du toggle du cadre', $e->errors(), 422);
        }
    }

    public function renewMandate(RenewMandateDirectorRequest $request)
    {
        try {
            $director = $this->director->renewMandate($request->all());

            return api_response(true, 'Renouvellement du mandat avec succès', $director, 200);
        } catch (ValidationException $e) {

            return api_response(false, 'Echec de la mise à jour', $e->errors(), 422);
        }
    }

    public function generatePdf()
    {
        try {
            $data = $this->director->generatePdf();

            return $data;
        } catch (Throwable $th) {
            return api_error($success = false, 'Une erreur s\'est produite lors de l\'opération', ['server' => $th->getMessage()]);
        }
    }
}
