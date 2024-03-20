<?php

namespace App\Http\Controllers\API\V1\Gourvernance\GeneralMeeting;

use App\Http\Controllers\Controller;
use App\Models\FileUpload;
use App\Models\Gourvernance\GeneralMeeting\AgActionTypeFile;
use App\Models\Gourvernance\GeneralMeeting\AgAction;
use App\Models\Gourvernance\GeneralMeeting\AgArchiveFile;
use App\Models\Gourvernance\GeneralMeeting\AgPresentShareholder;
use App\Models\Gourvernance\GeneralMeeting\AgStep;
use App\Models\Gourvernance\GeneralMeeting\AgStepFile;
use App\Models\Gourvernance\GeneralMeeting\AgStepTypeFile;
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
        $general_meetings = GeneralMeeting::with('step.type_files','files')->get();
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
                'type' => ['required',  Rule::in(GeneralMeeting::GENERAL_MEETING_TYPES) ],
            ]);

            $general_meeting = GeneralMeeting::create($validate_request);


            $general_meeting = $general_meeting->load('step.type_files','files');

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

            $general_meeting = $general_meeting->load('step.type_files','files');

            return self::apiResponse(true, "Information de l'AG", $general_meeting, 200);
        }catch( ValidationException $e ) {
            return self::apiResponse(false, "Echec de la récupération des infos de l'AG", $e->errors(), 422);
        }
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

    public function saveAttachmentMeeting(Request $request) {
        try {
            $validate_request = $request->validate([
                'general_meeting_id' => ['required','numeric'],
                'files' => ['array'],
            ]);

            $meetingId = $validate_request['general_meeting_id'];
            $general_meeting = GeneralMeeting::find($meetingId);

            $agStepId = $general_meeting->ag_step_id;

            // Mise à jour ou création des fichiers
            if ($request->has('files') && !empty($validate_request['files'])) {
                $files = $validate_request['files'];
                foreach ($files as $key => $file) {
                    AgStepFile::updateOrCreate(
                        ['ag_step_type_file_id' => $key],
                        ['file' => FileUpload::uploadFile($file,'ag_step_files') , 'general_meeting_id' => $meetingId]
                    );
                }
            }

            // Recherche des fichiers manquants
            $missingAgStepTypeFilesIds = AgStepTypeFile::where('ag_step_id', $agStepId)
                ->whereNotIn('id', function ($query) {
                    $query->select('ag_step_type_file_id')
                        ->from('ag_step_files');
                })
                ->pluck('id');


            if ($missingAgStepTypeFilesIds->isEmpty()) {
                // Mise à jour du statut de l'action
                GeneralMeeting::find($meetingId)->update(['ag_step_id' => AgStep::NEXT_STEP[$agStepId]]);
                return self::apiResponse(true, "Tous les fichiers ont été enregistrés", [], 200);
            } else {
                // Récupération des fichiers manquants
                $missingAgActionTypeFiles = AgStepTypeFile::whereIn('id', $missingAgStepTypeFilesIds)->get();
                return self::apiResponse(true, "Liste des fichiers manquants de cette tâche", $missingAgActionTypeFiles, 200);
            }

        }catch( ValidationException $e ) {
            return self::apiResponse(false, "Echec de la mise à jour de la tache", $e->errors(), 422);
        }
    }

    public function getAgStep() {

        $ag_steps = AgStep::with('type_files')->get();
        return self::apiResponse(true, "Statuts de l'AG", $ag_steps, 200);
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
