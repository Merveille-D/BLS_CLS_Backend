<?php

namespace App\Http\Controllers\API\V1\Gourvernance\GeneralMeeting;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGeneralMeetingRequest;
use App\Http\Requests\UpdateGeneralMeetingRequest;
use App\Models\FileUpload;
use App\Models\Gourvernance\GeneralMeeting\GeneralMeeting;
use App\Models\Utility;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class GeneralMeetingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $general_meetings = GeneralMeeting::with('fileUploads')->get();
        return Utility::apiResponse(true, "Liste des AG", $general_meetings, 200);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGeneralMeetingRequest $request)
    {
        try {
            $request['reference'] = 'AG-' . date('m') . '-' . date('Y');
            $general_meeting = GeneralMeeting::create($request->all());

            $general_meeting->status = "pending";

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

            $general_meeting = GeneralMeeting::find($request->general_meeting_id);

            $files = $request->docs['files'];
            $others_files = $request->docs['others_files'];

            foreach ($files as $fieldName => $file) {
                $general_meeting->update([
                    $fieldName => FileUpload::uploadFile($file, 'ag_documents'),
                    GeneralMeeting::DATE_FILE_FIELD[$fieldName] => now(),
                ]);
            }

            foreach ($others_files as $file) {
                $fileUpload = new FileUpload();

                $fileUpload->name = $file['name'];
                $fileUpload->file = FileUpload::uploadFile($file['file'], 'ag_documents');
                $fileUpload->status = $general_meeting->status;

                $general_meeting->fileUploads()->save($fileUpload);
            }

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
