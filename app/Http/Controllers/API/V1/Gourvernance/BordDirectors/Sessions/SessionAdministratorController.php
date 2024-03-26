<?php

namespace App\Http\Controllers\API\V1\Gourvernance\BordDirectors\Sessions;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSessionAdministratorRequest;
use App\Http\Requests\UpdateSessionAdministratorRequest;
use App\Models\Gourvernance\BoardDirectors\Sessions\SessionAdministrator;
use App\Models\Utility;
use App\Repositories\SessionAdministratorRepository;
use Illuminate\Validation\ValidationException;

class SessionAdministratorController extends Controller
{
    public function __construct(private SessionAdministratorRepository $session) {

    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $session_administrators = SessionAdministrator::all();
        return api_response(true, "Liste des Sessions", $session_administrators, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSessionAdministratorRequest $request)
    {
        try {

            $session_administrator = $this->session->store($request);
            return api_response(true, "Succès de l'enregistrement du CA", $session_administrator, 200);
        } catch (ValidationException $e) {
            return api_response(false, "Echec de l'enregistrement du CA", $e->errors(), 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(SessionAdministrator $session_administrator)
    {
        try {
            $session_administrator->load('fileUploads');
            return api_response(true, "Information du CA", $session_administrator, 200);
        } catch (ValidationException $e) {
            return api_response(false, "Echec de la récupération des infos du CA", $e->errors(), 422);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSessionAdministratorRequest $request, SessionAdministrator $session_administrator)
    {
        //
    }

    public function attachment(UpdateSessionAdministratorRequest $request)
    {
        try {
            $session_administrator = $this->session->attachement($request);
            return api_response(true, "Mis à jour du CA avec succès", $session_administrator, 200);
        }catch( ValidationException $e ) {
            return api_response(false, "Echec de la mise à jour du CA ", $e->errors(), 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
