<?php

namespace App\Http\Controllers\API\V1\Gourvernance\BordDirectors\Administrators;

use App\Http\Controllers\Controller;
use App\Http\Requests\Administrator\AddAdministratorRequest;
use App\Http\Requests\Administrator\RenewMandateAdministratorRequest;
use App\Http\Requests\Administrator\UpdateAdministratorRequest;
use App\Http\Requests\Committee\ToggleExecutiveCommitteeRequest;
use App\Models\Gourvernance\BoardDirectors\Administrators\CaAdministrator;
use App\Repositories\SessionAdministrator\AdministratorRepository;
use Illuminate\Validation\ValidationException;

class AdministratorController extends Controller
{
    public function __construct(private AdministratorRepository $adminRepo) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $administrators = CaAdministrator::get()->map(function ($administrator) {
            $administrator->mandates = $administrator->mandates;

            return $administrator;
        });

        return api_response(true, 'Liste des Administrateurs', $administrators, 201);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddAdministratorRequest $request)
    {
        $ca_administrator = $this->adminRepo->add($request);

        $data = $ca_administrator->toArray();
        $data['mandates'] = $ca_administrator->mandates;

        return api_response(true, 'Administrateur ajouté avec succès', $data, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(CaAdministrator $ca_administrator)
    {
        try {
            $data = $ca_administrator->toArray();
            $data['mandates'] = $ca_administrator->mandates;

            return api_response(true, "Information de l'administrateur", $data, 200);
        } catch (ValidationException $e) {
            return api_response(false, "Echec de la récupération des infos de l'administrateur", $e->errors(), 422);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CaAdministrator $ca_administrator, UpdateAdministratorRequest $request)
    {
        try {
            $this->adminRepo->update($ca_administrator, $request->all());

            $data = $ca_administrator->toArray();
            $data['mandates'] = $ca_administrator->mandates;

            return api_response(true, 'Mis à jour du directeur avec succès', $data, 200);
        } catch (ValidationException $e) {

            return api_response(false, 'Echec de la mise à jour', $e->errors(), 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        try {
            $ca_administrator->delete();

            return api_response(true, "Succès de la suppression de l'administrateur", null, 200);
        } catch (ValidationException $e) {
            return api_response(false, "Echec de la supression de l'administrateur", $e->errors(), 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function settings()
    {
        return api_response(true, 'select box values recupérés avec succès', $this->adminRepo->settings());
    }

    public function toggleExecutiveCommittee(ToggleExecutiveCommitteeRequest $request, CaAdministrator $ca_administrator)
    {
        try {
            $committee = $this->adminRepo->toggle($ca_administrator, $request->validated());

            return api_response(true, 'Succès du toggle du cadre', 200);
        } catch (ValidationException $e) {
            return api_response(false, 'Echec du toggle du cadre', $e->errors(), 422);
        }
    }

    public function renewMandate(RenewMandateAdministratorRequest $request)
    {
        try {
            $administrator = $this->adminRepo->renewMandate($request->all());

            return api_response(true, 'Renouvellement du mandat avec succès', $administrator, 200);
        } catch (ValidationException $e) {

            return api_response(false, 'Echec de la mise à jour', $e->errors(), 422);
        }
    }
}
