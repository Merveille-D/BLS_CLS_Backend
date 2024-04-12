<?php

namespace App\Http\Controllers\API\V1\Gourvernance\ExecutiveManagement\Directors;

use App\Http\Controllers\Controller;
use App\Http\Requests\Director\AddDirectorRequest;
use App\Models\Gourvernance\ExecutiveManagement\Directors\Director;
use App\Repositories\ManagementCommittee\DirectorRepository;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class DirectorController extends Controller
{
    public function __construct(private DirectorRepository $director) {

    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $directors = Director::all();
        return api_response(true, 'Liste des Directeurs', $directors, 201);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddDirectorRequest $request)
    {
        $admin = $this->director->add($request);

        return api_response(true, 'Directeur ajouté avec succès', $admin, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Director $director)
    {
        try {
            return api_response(true, "Infos du directeur", $director, 200);
        }catch( ValidationException $e ) {
            return api_response(false, "Echec de la récupération des infos du directeur", $e->errors(), 422);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Director $director)
    {
        try {
            $this->director->update($director, $request->all());
            return api_response(true, "Mis à jour du texte avec succès", $director, 200);
        } catch (ValidationException $e) {

            return api_response(false, "Echec de la mise à jour", $e->errors(), 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Director $director)
    {
        try {
            $director->delete();
            return api_response(true, "Succès de la suppression du directeur", null, 200);
        }catch (ValidationException $e) {
                return api_response(false, "Echec de la supression du directeur", $e->errors(), 422);
        }
    }
}
