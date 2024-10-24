<?php

namespace App\Http\Controllers\API\V1\Gourvernance\GeneralMeeting;

use App\Http\Controllers\Controller;
use App\Http\Requests\GeneralMeeting\GeneratePdfGeneralMeetingRequest;
use App\Http\Requests\GeneralMeeting\StoreGeneralMeetingRequest;
use App\Http\Requests\GeneralMeeting\UpdateAttachementGeneralMeetingRequest;
use App\Http\Requests\GeneralMeeting\UpdateGeneralMeetingRequest;
use App\Http\Resources\GeneralMeeting\TaskGeneralMeetingResource;
use App\Models\Gourvernance\GeneralMeeting\GeneralMeeting;
use App\Models\Gourvernance\GeneralMeeting\TaskGeneralMeeting;
use App\Repositories\GeneralMeeting\GeneralMeetingRepository;
use Illuminate\Validation\ValidationException;

class GeneralMeetingController extends Controller
{
    public function __construct(private GeneralMeetingRepository $meeting) {

    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->meeting->checkStatus();

        $general_meetings = GeneralMeeting::when(request('status') === 'pending', function($query) {
            $query->where('status', 'pending');
        }, function($query) {
            $query->where('status', 'post_ag')
                  ->orWhere('status', 'closed');
        })->get()->map(function ($meeting) {
            $meeting->files = $meeting->files;
            $meeting->next_task = new TaskGeneralMeetingResource($meeting->next_task);
            return $meeting;
        });

        return api_response(true, "AG en cours", $general_meetings, 200);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGeneralMeetingRequest $request)
    {
        try {
            $general_meeting = $this->meeting->store($request);
            return api_response(true, "Succès de l'enregistrement de l'AG", $general_meeting, 200);
        }catch (ValidationException $e) {
                return api_response(false, "Echec de l'enregistrement de l'AG", $e->errors(), 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(GeneralMeeting $general_meeting)
    {
        try {
            $data = $general_meeting->load('tasks')->toArray();
            $data['files'] = $general_meeting->files;
            $data['next_task'] = $general_meeting->next_task;

            return api_response(true, "Information de l'AG", $data, 200);
        }catch( ValidationException $e ) {
            return api_response(false, "Echec de la récupération des infos de l'AG", $e->errors(), 422);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGeneralMeetingRequest $request, GeneralMeeting $general_meeting)
    {
        try {
            $this->meeting->update($general_meeting, $request->all());
            return api_response(true, "Ajout du document avec succès", $general_meeting, 200);
        } catch (ValidationException $e) {

            return api_response(false, "Echec de la mise à jour de l'AG", $e->errors(), 422);
        }
    }

    public function attachment(UpdateAttachementGeneralMeetingRequest $request)
    {
        try {
            $general_meeting = $this->meeting->attachement($request);
            return api_response(true, "Mis à jour de l'AG avec suucès", $general_meeting, 200);
        }catch( ValidationException $e ) {
            return api_response(false, "Echec de la mise à jour de l'AG ", $e->errors(), 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function generatePdfFicheSuivi(GeneratePdfGeneralMeetingRequest $request) {
        try {

            $data = $this->meeting->generatePdf($request);
            return $data;
        } catch (\Throwable $th) {
            return api_error($success = false, 'Une erreur s\'est produite lors de l\'opération', ['server' => $th->getMessage()]);
        }
    }
}
