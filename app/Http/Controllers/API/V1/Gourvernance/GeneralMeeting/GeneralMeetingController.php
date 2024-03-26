<?php

namespace App\Http\Controllers\API\V1\Gourvernance\GeneralMeeting;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGeneralMeetingRequest;
use App\Http\Requests\UpdateGeneralMeetingRequest;
use App\Models\Gourvernance\GeneralMeeting\GeneralMeeting;
use App\Models\Utility;
use App\Repositories\GeneralMeetingRepository;
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
        $general_meetings = GeneralMeeting::all();
        return Utility::apiResponse(true, "Liste des AG", $general_meetings, 200);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGeneralMeetingRequest $request)
    {
        try {
            $general_meeting = $this->meeting->store($request);
            return Utility::apiResponse(true, "Succès de l'enregistrement de l'AG", $general_meeting, 200);
        }catch (ValidationException $e) {
                return Utility::apiResponse(false, "Echec de l'enregistrement de l'AG", $e->errors(), 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(GeneralMeeting $general_meeting)
    {
        try {

            $general_meeting->load('fileUploads');
            return Utility::apiResponse(true, "Information de l'AG", $general_meeting, 200);
        }catch( ValidationException $e ) {
            return Utility::apiResponse(false, "Echec de la récupération des infos de l'AG", $e->errors(), 422);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGeneralMeetingRequest $request, GeneralMeeting $general_meeting)
    {
        //
    }


    public function attachment(UpdateGeneralMeetingRequest $request)
    {
        try {

            $general_meeting = $this->meeting->attachement($request);
            return Utility::apiResponse(true, "Mis à jour de l'AG avec suucès", $general_meeting, 200);

        }catch( ValidationException $e ) {
            return Utility::apiResponse(false, "Echec de la mise à jour de l'AG ", $e->errors(), 422);
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
