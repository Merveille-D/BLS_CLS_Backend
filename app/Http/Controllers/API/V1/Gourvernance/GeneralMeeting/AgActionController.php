<?php

namespace App\Http\Controllers\API\V1\Gourvernance\GeneralMeeting;

use App\Http\Controllers\Controller;
use App\Models\FileUpload;
use App\Models\Gourvernance\GeneralMeeting\AgAction;
use App\Models\Gourvernance\GeneralMeeting\AgActionFile;
use App\Models\Gourvernance\GeneralMeeting\AgActionTypeFile;
use App\Models\Gourvernance\GeneralMeeting\AgType;
use App\Models\Gourvernance\GeneralMeeting\GeneralMeeting;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AgActionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
                'general_meeting_id' => ['required','numeric'],
                'ag_type_id' => ['required','numeric'],
            ]);

            $agAction = AgAction::create([
                'title' => $validate_request['title'],
                'closing_date' => $validate_request['closing_date'],
                'is_file' => $validate_request['is_file'] ?? false,
                'general_meeting_id' =>  $validate_request['general_meeting_id'],
                'ag_type_id' => $validate_request['ag_type_id'],
            ]);

            if($request->boolean('is_file')) {
                foreach($request->type_files as $type_file) {
                    AgActionTypeFile::create([
                        'name' => $type_file,
                        'ag_action_id' => $agAction->id,
                    ]);
                }
            }

            $general_meeting = GeneralMeeting::with('actions.actionsTypeFile', 'actions.actionsFile', 'archives', 'shareholders')->find($validate_request['general_meeting_id']);
            return self::apiResponse(true, "Action ajouté avec succès", $general_meeting, 200);
        }catch( ValidationException $e ) {
            return self::apiResponse(false, "Echec de l'enregistrement de l'AG", $e->errors(), 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    public function updateAction(Request $request) {
        try {
            $validate_request = $request->validate([
                'ag_action_id' => ['required','numeric'],
                'status' => ['required'],
                'files' => ['required','array'],
            ]);

            $agActionId = $validate_request['ag_action_id'];
            $status = $validate_request['status'];
            $files = $validate_request['files'];

            // Mise à jour ou création des fichiers
            foreach ($files as $key => $file) {
                if (!is_null($file)) {
                    AgActionFile::updateOrCreate(
                        ['ag_action_type_file_id' => $key],
                        ['file' => FileUpload::uploadFile($file['file'],'ag_action_files') , 'ag_action_id' => $agActionId]
                    );
                }
            }

            // Recherche des fichiers manquants
            $missingAgActionTypeFilesIds = AgActionTypeFile::where('ag_action_id', $agActionId)
                ->whereNotIn('id', function ($query) {
                    $query->select('ag_action_type_file_id')
                        ->from('ag_action_files');
                })
                ->pluck('id');


            if ($missingAgActionTypeFilesIds->isEmpty()) {
                // Mise à jour du statut de l'action
                AgAction::where('id', $agActionId)->update(['status' => $status]);
                return self::apiResponse(true, "Tâche mise à jour avec succès", [], 200);
            } else {
                // Récupération des fichiers manquants
                $missingAgActionTypeFiles = AgActionTypeFile::whereIn('id', $missingAgActionTypeFilesIds)->get();
                return self::apiResponse(true, "Liste des fichiers manquants de cette tâche", $missingAgActionTypeFiles, 200);
            }

        }catch( ValidationException $e ) {
            return self::apiResponse(false, "Echec de la mise à jour de la tache", $e->errors(), 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function getAgTypes() {

        $ag_types = AgType::all();
        return self::apiResponse(true, "Etape de l'AG", $ag_types, 200);
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
