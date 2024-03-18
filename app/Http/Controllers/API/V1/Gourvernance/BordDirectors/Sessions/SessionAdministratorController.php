<?php

namespace App\Http\Controllers\API\V1\Gourvernance\BordDirectors\Sessions;

use App\Http\Controllers\Controller;
use App\Models\FileUpload;
use App\Models\Gourvernance\BoardDirectors\Sessions\SessionAction;
use App\Models\Gourvernance\BoardDirectors\Sessions\SessionActionTypeFile;
use App\Models\Gourvernance\BoardDirectors\Sessions\SessionAdministrator;
use App\Models\Gourvernance\BoardDirectors\Sessions\SessionArchiveFile;
use App\Models\Gourvernance\BoardDirectors\Sessions\SessionPresentAdministrator;
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
        $session_administrators = SessionAdministrator::with('actions.actionsTypeFile', 'actions.actionsFile', 'archives', 'administrators')->get();
        return self::apiResponse(true, "Liste des sessions d'administrations", $session_administrators, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validate_request =  $request->validate([
                'reference' => ['required', 'string'],
                'session_date' => ['required', 'date'],
                'type' => ['required',  Rule::in(SessionAdministrator::SESSION_MEETING_TYPES) ],
            ]);

            $session_administrator = SessionAdministrator::create($validate_request);

            $actions = SessionAction::ACTIONS;

            foreach($actions as $key => $items) {
                foreach($items as $index => $item) {
                    if (isset($item['title'])) {
                        $session_action = SessionAction::create([
                            'title' => $item['title'],
                            'closing_date' => $item['closing_date'],
                            'is_file' => $item['is_file'] ?? false,
                            'session_administrator_id' => $session_administrator->id,
                            'session_type_id' => $key,
                        ]);

                        if($item['is_file']) {
                            foreach($item['files'] as $file) {
                                SessionActionTypeFile::create([
                                    'name' => $file,
                                    'session_action_id' => $session_action->id,
                                ]);
                            }
                        }

                    } else {
                        foreach ($item as $subitem) {
                            SessionAction::create([
                                'title' => $subitem['title'],
                                'session_administrator_id' => $session_administrator->id,
                                'session_type_id' => $key,
                                'step_ca_day' => $index,
                            ]);
                        }
                    }
                }
            }

            $session_administrator = $session_administrator->load('actions.actionsTypeFile', 'actions.actionsFile', 'archives', 'administrators');


            return self::apiResponse(true, "Succès de l'enregistrement de la session d'administration", $session_administrator, 200);
        }catch (ValidationException $e) {
                return self::apiResponse(false, "Echec de l'enregistrement de la session d'administration", $e->errors(), 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(SessionAdministrator $sessionAdministrator)
    {
        try {

            $sessionAdministrator = $sessionAdministrator->load('actions.actionsTypeFile', 'actions.actionsFile', 'archives', 'administrators');

            return self::apiResponse(true, "Information de la session d'administration", $sessionAdministrator, 200);
        }catch( ValidationException $e ) {
            return self::apiResponse(false, "Echec de la récupération des infos de la session d'administration", $e->errors(), 422);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SessionAdministrator $sessionAdministrator)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SessionAdministrator $sessionAdministrator)
    {
        //
    }

    public function saveAdministratorsByCa(Request $request) {
        try {
            $validate_request =  $request->validate([
                'session_administrator_id' => ['required', 'numeric'],
                'ca_administrators_id' => ['required', 'array'],
            ]);

            SessionPresentAdministrator::where('session_administrator_id',$validate_request['session_administrator_id'])->delete();

            foreach($validate_request['ca_administrators_id'] as $item) {
                SessionPresentAdministrator::create([
                    'ca_administrator_id' => $item,
                    'session_administrator_id' => $validate_request['session_administrator_id'],
                ]);
            }

            return self::apiResponse(true, "Succès de l'enregistrement des administrateurs", [], 200);
        }catch( ValidationException $e ) {
            return self::apiResponse(false, "Echec de l'enregistrement des administrateurs", $e->errors(), 422);
        }
    }

    public function getAdministratorsByCa(Request $request) {

        try {
            $validate_request =  $request->validate([
                'session_administrator_id' => ['required', 'numeric'],
            ]);

            $AdministratorsBySessionAdministrator = SessionPresentAdministrator::where('session_administrator_id', $validate_request['session_administrator_id'])->get();
            return self::apiResponse(true, "Administrateurs présent à la session du comité", $AdministratorsBySessionAdministrator, 200);
        }catch( ValidationException $e ) {
            return self::apiResponse(false, "Echec de la récupération des administrateurs du comité", $e->errors(), 422);
        }
    }

    public function saveArchiveFileCa(Request $request) {
        try {
            $validate_request = $request->validate([
                'session_administrator_id' => ['required','numeric'],
                'archives' => ['required','array'],
            ]);

            $session_administrator_id = $validate_request['session_administrator_id'];
            $archives = $validate_request['archives'];

            foreach ($archives as $archive) {

                    SessionArchiveFile::create([
                        'name' => $archive['name'],
                        'file' => FileUpload::uploadFile($archive['file'],'ca_archive_files'),
                        'session_administrator_id' => $session_administrator_id,
                    ]);
            }

            return self::apiResponse(true, "Ajout avec succès des archives de la session d'administrateur", [], 200);
        }catch( ValidationException $e ) {
            return self::apiResponse(false, "Echec de l'ajout des archives de la session d'administrateur", $e->errors(), 422);
        }
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
