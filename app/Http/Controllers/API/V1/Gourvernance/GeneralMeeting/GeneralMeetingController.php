<?php

namespace App\Http\Controllers\API\V1\Gourvernance\GeneralMeeting;

use App\Http\Controllers\Controller;
use App\Models\FileUpload;
use App\Models\Gourvernance\GeneralMeeting\GeneralMeeting;
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
        $general_meetings = GeneralMeeting::all();
        return self::apiResponse(true, "Liste des AG", $general_meetings, 200);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        try {
            $validate_request =  $request->validate([
                'libelle' => ['required', 'string'],
                'reference' => ['required', 'string'],
                'meeting_date' => ['required', 'date'],
            ]);

            $validate_request['status'] = 'pending';
            $general_meeting = GeneralMeeting::create($validate_request);

            return self::apiResponse(true, "Succès de l'enregistrement de l'AG", $general_meeting, 200);
        }catch (ValidationException $e) {
                return self::apiResponse(false, "Echec de l'enregistrement de l'AG", $e->errors(), 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(GeneralMeeting $general_meeting)
    {
        try {
            return self::apiResponse(true, "Information de l'AG", $general_meeting, 200);
        }catch( ValidationException $e ) {
            return self::apiResponse(false, "Echec de la récupération des infos de l'AG", $e->errors(), 422);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, GeneralMeeting $general_meeting)
    {
        try {
            $validate_request = $request->validate([
                'files' => ['required', 'array'],
                'files.*' => ['required', 'file'],
                'status' => [Rule::in(GeneralMeeting::GENERAL_MEETING_STATUS) ],
            ]);

            $files = $request->file('files');
            foreach ($files as $fieldName => $file) {
                $filePath = FileUpload::uploadFile($file, 'ag_documents');
                $general_meeting->update([
                    $fieldName => $filePath,
                ]);
            }

            if ($request->has('status')) {
                $general_meeting->update([
                    'status' => $validate_request['status'],
                ]);
            }

            return self::apiResponse(true, "Mis à jour de l'AG avec suucès", $general_meeting, 200);

        }catch( ValidationException $e ) {
            return self::apiResponse(false, "Echec de la mise à jour de l'AG ", $e->errors(), 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public static function apiResponse($success, $message, $data = [], $status)
    {
        $response = response()->json([
            'success' => $success,
            'message' => $message,
            'body' => $data
        ], $status);
        return $response;
    }
}
