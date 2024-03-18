<?php

namespace App\Http\Controllers\API\V1\Gourvernance\BordDirectors\Sessions;

use App\Models\Gourvernance\BoardDirectors\Sessions\SessionAction;
use App\Http\Controllers\Controller;
use App\Models\FileUpload;
use App\Models\Gourvernance\BoardDirectors\Sessions\SessionActionFile;
use App\Models\Gourvernance\BoardDirectors\Sessions\SessionActionTypeFile;
use App\Models\Gourvernance\BoardDirectors\Sessions\SessionAdministrator;
use App\Models\Gourvernance\BoardDirectors\Sessions\SessionType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class SessionActionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validate_request = $request->validate([
                'title' => ['required','string'],
                'closing_date' => ['required','date'],
                'session_administrator_id' => ['required','numeric'],
                'session_type_id' => ['required','numeric'],
            ]);

            $sessionAction = SessionAction::create([
                'title' => $validate_request['title'],
                'closing_date' => $validate_request['closing_date'],
                'is_file' => $validate_request['is_file'] ?? false,
                'session_administrator_id' =>  $validate_request['session_administrator_id'],
                'session_type_id' => $validate_request['session_type_id'],
            ]);

            if($request->boolean('is_file')) {
                foreach($request->type_files as $type_file) {
                    SessionActionTypeFile::create([
                        'name' => $type_file,
                        'session_action_id' => $sessionAction->id,
                    ]);
                }
            }

            $session_administrator = SessionAdministrator::with('actions.actionsTypeFile', 'actions.actionsFile', 'archives', 'administrators')->find($validate_request['session_administrator_id']);
            return self::apiResponse(true, "Action ajouté avec succès", $session_administrator, 200);
        }catch( ValidationException $e ) {
            return self::apiResponse(false, "Echec de l'enregistrement de l'session", $e->errors(), 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(SessionAction $sessionAction)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SessionAction $sessionAction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SessionAction $sessionAction)
    {
        //
    }

    public function updateAction(Request $request) {
        try {
            $validate_request = $request->validate([
                'session_action_id' => ['required','numeric'],
                'status' => ['required'],
                'files' => ['required','array'],
            ]);

            $sessionActionId = $validate_request['session_action_id'];
            $status = $validate_request['status'];
            $files = $validate_request['files'];

            // Mise à jour ou création des fichiers
            foreach ($files as $key => $file) {
                if (!is_null($file)) {
                    SessionActionFile::updateOrCreate(
                        ['session_action_type_file_id' => $key],
                        ['file' => FileUpload::uploadFile($file['file'],'session_action_files') , 'session_action_id' => $sessionActionId]
                    );
                }
            }

            // Recherche des fichiers manquants
            $missingSessionActionTypeFilesIds = SessionActionTypeFile::where('session_action_id', $sessionActionId)
                ->whereNotIn('id', function ($query) {
                    $query->select('session_action_type_file_id')
                        ->from('session_action_files');
                })
                ->pluck('id');


            if ($missingSessionActionTypeFilesIds->isEmpty()) {
                // Mise à jour du statut de l'action
                SessionAction::where('id', $sessionActionId)->update(['status' => $status]);
                return self::apiResponse(true, "Tâche mise à jour avec succès", [], 200);
            } else {
                // Récupération des fichiers manquants
                $missingSessionActionTypeFiles = SessionActionTypeFile::whereIn('id', $missingSessionActionTypeFilesIds)->get();
                return self::apiResponse(true, "Liste des fichiers manquants de cette tâche", $missingSessionActionTypeFiles, 200);
            }

        }catch( ValidationException $e ) {
            return self::apiResponse(false, "Echec de la mise à jour de la tache", $e->errors(), 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SessionAction $sessionAction)
    {
        //
    }

    public function getSessionTypes() {

        $session_types = SessionType::all();
        return self::apiResponse(true, "Etape de l'session", $session_types, 200);
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
