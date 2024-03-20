<?php

namespace App\Http\Controllers\API\V1\Gourvernance\BordDirectors\Sessions;

use App\Http\Controllers\Controller;
use App\Models\FileUpload;
use App\Models\Gourvernance\BoardDirectors\Sessions\SessionAction;
use App\Models\Gourvernance\BoardDirectors\Sessions\SessionActionTypeFile;
use App\Models\Gourvernance\BoardDirectors\Sessions\SessionAdministrator;
use App\Models\Gourvernance\BoardDirectors\Sessions\SessionArchiveFile;
use App\Models\Gourvernance\BoardDirectors\Sessions\SessionPresentAdministrator;
use App\Models\Gourvernance\BoardDirectors\Sessions\SessionStep;
use App\Models\Gourvernance\BoardDirectors\Sessions\SessionStepFile;
use App\Models\Gourvernance\BoardDirectors\Sessions\SessionStepTypeFile;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class SessionAdministratorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $session_administrators = SessionAdministrator::with('step.type_files','files')->get();
        return self::apiResponse(true, "Liste des Sessions", $session_administrators, 200);
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
                'session_date' => ['required', 'date'],
                'type' => ['required',  Rule::in(SessionAdministrator::SESSION_MEETING_TYPES) ],
            ]);

            $session_administrator = SessionAdministrator::create($validate_request);


            $session_administrator = $session_administrator->load('step.type_files','files');

            return self::apiResponse(true, "Succès de l'enregistrement du CA", $session_administrator, 200);
        }catch (ValidationException $e) {
                return self::apiResponse(false, "Echec de l'enregistrement du CA", $e->errors(), 422);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(SessionAdministrator $session_administrator)
    {
        try {

            $session_administrator = $session_administrator->load('step.type_files','files');

            return self::apiResponse(true, "Information du CA", $session_administrator, 200);
        }catch( ValidationException $e ) {
            return self::apiResponse(false, "Echec de la récupération des infos du CA", $e->errors(), 422);
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
                'session_administrator_id' => ['required','numeric'],
                'files' => ['array'],
            ]);

            $meetingId = $validate_request['session_administrator_id'];
            $session_administrator = SessionAdministrator::find($meetingId);


            $sessionStepId = $session_administrator->session_step_id;


            // Mise à jour ou création des fichiers
            if ($request->has('files') && !empty($validate_request['files'])) {
                $files = $validate_request['files'];
                foreach ($files as $key => $file) {
                    SessionStepFile::updateOrCreate(
                        ['session_step_type_file_id' => $key],
                        ['file' => FileUpload::uploadFile($file,'session_step_files') , 'session_administrator_id' => $meetingId]
                    );
                }
            }

            // Recherche des fichiers manquants
            $missingSessionStepTypeFilesIds = SessionStepTypeFile::where('session_step_id', $sessionStepId)
                ->whereNotIn('id', function ($query) {
                    $query->select('session_step_type_file_id')
                        ->from('session_step_files');
                })
                ->pluck('id');


            if ($missingSessionStepTypeFilesIds->isEmpty()) {
                // Mise à jour du statut de l'action
                SessionAdministrator::find($meetingId)->update(['session_step_id' => SessionStep::NEXT_STEP[$sessionStepId]]);
                return self::apiResponse(true, "Tous les fichiers ont été enregistrés", [], 200);
            } else {
                // Récupération des fichiers manquants
                $missingSessionActionTypeFiles = SessionStepTypeFile::whereIn('id', $missingSessionStepTypeFilesIds)->get();
                return self::apiResponse(true, "Liste des fichiers manquants de cette tâche", $missingSessionActionTypeFiles, 200);
            }

        }catch( ValidationException $e ) {
            return self::apiResponse(false, "Echec de la mise à jour de la tache", $e->errors(), 422);
        }
    }

    public function getSessionStep() {

        $session_steps = SessionStep::with('type_files')->get();
        return self::apiResponse(true, "Statuts du CA", $session_steps, 200);
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
