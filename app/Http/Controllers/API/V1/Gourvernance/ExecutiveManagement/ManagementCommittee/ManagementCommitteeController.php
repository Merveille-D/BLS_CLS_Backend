<?php

namespace App\Http\Controllers\API\V1\Gourvernance\ExecutiveManagement\ManagementCommittee;

use App\Http\Controllers\Controller;
use App\Http\Requests\ManagementCommittee\GeneratePdfManagementCommitteeRequest;
use App\Http\Requests\ManagementCommittee\StoreManagementCommitteeRequest;
use App\Http\Requests\ManagementCommittee\UpdateAttachementManagementCommitteeRequest;
use App\Http\Requests\ManagementCommittee\UpdateManagementCommitteeRequest;
use App\Http\Resources\ManagementCommittee\TaskManagementCommitteeResource;
use App\Models\Gourvernance\ExecutiveManagement\ManagementCommittee\ManagementCommittee;
use App\Repositories\ManagementCommittee\ManagementCommitteeRepository;
use Illuminate\Validation\ValidationException;

class ManagementCommitteeController extends Controller
{
    public function __construct(private ManagementCommitteeRepository $session) {

    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->session->checkStatus();

        $management_committees = ManagementCommittee::when(request('status') === 'pending', function($query) {
            $query->where('status', 'pending');
        }, function($query) {
            $query->where('status', 'post_cd')
                  ->orWhere('status', 'closed');
        })->get()->map(function ($meeting) {
            $meeting->files = $meeting->files;
            $meeting->next_task = new TaskManagementCommitteeResource($meeting->next_task);
            return $meeting;
        });

        return api_response(true, "Liste des Sessions", $management_committees, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreManagementCommitteeRequest $request)
    {
        try {
            $management_committee = $this->session->store($request);
            return api_response(true, "Succès de l'enregistrement du CD", $management_committee, 200);
        } catch (ValidationException $e) {
            return api_response(false, "Echec de l'enregistrement du CD", $e->errors(), 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ManagementCommittee $management_committee)
    {
        try {
            $data = $management_committee->toArray();
            $data['files'] = $management_committee->files;
            $data['next_task'] = new TaskManagementCommitteeResource($management_committee->next_task);

            return api_response(true, "Information du CD", $data, 200);
        } catch (ValidationException $e) {
            return api_response(false, "Echec de la récupération des infos du CD", $e->errors(), 422);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateManagementCommitteeRequest $request, ManagementCommittee $management_committee)
    {
        try {
            $this->session->update($management_committee, $request->all());
            return api_response(true, "CA mis à jour avec succès", $management_committee, 200);
        } catch (ValidationException $e) {

            return api_response(false, "Echec de la mise à jour du CD", $e->errors(), 422);
        }
    }

    public function attachment(UpdateAttachementManagementCommitteeRequest $request)
    {
        try {
            $management_committee = $this->session->attachement($request);
            return api_response(true, "Mis à jour du CD avec succès", $management_committee, 200);
        }catch( ValidationException $e ) {
            return api_response(false, "Echec de la mise à jour du CD ", $e->errors(), 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function generatePdfFicheSuivi(GeneratePdfManagementCommitteeRequest $request) {
        try {

            $data = $this->session->generatePdf($request);
            return $data;
        } catch (\Throwable $th) {
            return api_error($success = false, 'Une erreur s\'est produite lors de l\'opération', ['server' => $th->getMessage()]);
        }
    }
}
