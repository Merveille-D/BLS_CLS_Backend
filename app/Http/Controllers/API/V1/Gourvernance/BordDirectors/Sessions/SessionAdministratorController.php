<?php

namespace App\Http\Controllers\API\V1\Gourvernance\BordDirectors\Sessions;

use App\Http\Controllers\Controller;
use App\Http\Requests\SessionAdministrator\GeneratePdfSessionAdministratorRequest;
use App\Http\Requests\SessionAdministrator\StoreSessionAdministratorRequest;
use App\Http\Requests\SessionAdministrator\UpdateAttachementSessionAdministratorRequest;
use App\Http\Requests\SessionAdministrator\UpdateSessionAdministratorRequest;
use App\Http\Resources\SessionAdministrator\TaskSessionAdministratorResource;
use App\Models\Gourvernance\BoardDirectors\Sessions\SessionAdministrator;
use App\Repositories\SessionAdministrator\SessionAdministratorRepository;
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
        $this->session->checkStatus();

        $session_administrators = SessionAdministrator::when(request('status') === 'pending', function($query) {
            $query->where('status', 'pending');
        }, function($query) {
            $query->where('status', 'post_ca')
                  ->orWhere('status', 'closed');
        })->get()->map(function ($meeting) {
            $meeting->files = $meeting->files;
            $meeting->next_task = new TaskSessionAdministratorResource($meeting->next_task);
            return $meeting;
        });

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
            $data = $session_administrator->toArray();
            $data['files'] = $session_administrator->files;
            $data['next_task'] = $session_administrator->next_task;

            return api_response(true, "Information du CA", $data, 200);
        } catch (ValidationException $e) {
            return api_response(false, "Echec de la récupération des infos du CA", $e->errors(), 422);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSessionAdministratorRequest $request, SessionAdministrator $session_administrator)
    {
        try {
            $this->session->update($session_administrator, $request->all());
            return api_response(true, "CA mis à jour avec succès", $session_administrator, 200);
        } catch (ValidationException $e) {

            return api_response(false, "Echec de la mise à jour du CA", $e->errors(), 422);
        }
    }

    public function attachment(UpdateAttachementSessionAdministratorRequest $request)
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

    public function generatePdfFicheSuivi(GeneratePdfSessionAdministratorRequest $request) {
        try {
            $data = $this->session->generatePdf($request);
            return $data;
        } catch (\Throwable $th) {
            return api_error($success = false, 'Une erreur s\'est produite lors de l\'opération', ['server' => $th->getMessage()]);
        }
    }
}
