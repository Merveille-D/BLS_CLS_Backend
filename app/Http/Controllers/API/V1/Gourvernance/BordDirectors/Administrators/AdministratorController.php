<?php

namespace App\Http\Controllers\API\V1\Gourvernance\BordDirectors\Administrators;

use App\Enums\AdminType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Administrator\AddAdministratorRequest;
use App\Http\Resources\Administrator\AdministratorCollection;
use App\Models\Gourvernance\BoardDirectors\Administrators\CaAdministrator;
use App\Repositories\AdministratorRepository;
use Illuminate\Http\Request;

class AdministratorController extends Controller
{
    public function __construct(private AdministratorRepository $adminRepo) {

    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new AdministratorCollection(CaAdministrator::administrator()->paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddAdministratorRequest $request)
    {
        $admin = $this->adminRepo->add($request);

        return api_response(true, 'Administrateur ajouté avec succès', $admin, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    /**
     * Remove the specified resource from storage.
     */
    public function settings()
    {
        return api_response(true, 'select box values recupérés avec succès', $this->adminRepo->settings());
    }
}
