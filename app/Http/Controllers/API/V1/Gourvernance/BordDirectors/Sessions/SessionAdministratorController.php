<?php

namespace App\Http\Controllers\API\V1\Gourvernance\BordDirectors\Sessions;

use App\Http\Controllers\Controller;
use App\Models\FileUpload;
use App\Models\Gourvernance\BoardDirectors\Sessions\SessionAdministrator;
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
        $session_administrators = SessionAdministrator::all();
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
            ]);

            $validate_request['status'] = 'pending';

            $session_administrator = SessionAdministrator::create($validate_request);

            return self::apiResponse(true, "Succès de l'enregistrement du CA", $session_administrator, 200);
        } catch (ValidationException $e) {
            return self::apiResponse(false, "Echec de l'enregistrement du CA", $e->errors(), 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(SessionAdministrator $session_administrator)
    {
        try {

            return self::apiResponse(true, "Information du CA", $session_administrator, 200);
        } catch (ValidationException $e) {
            return self::apiResponse(false, "Echec de la récupération des infos du CA", $e->errors(), 422);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SessionAdministrator $session_administrator)
    {
        try {
            $validate_request = $request->validate([
                'files' => ['required', 'array'],
                'files.*' => ['required', 'file'],
                'status' => ['required',Rule::in(SessionAdministrator::SESSION_MEETING_STATUS)],
            ]);

            $files = $request->file('files');
            foreach ($files as $fieldName => $file) {
                $filePath = FileUpload::uploadFile($file, 'ag_documents');
                $session_administrator->update([
                    $fieldName => $filePath,
                ]);
            }

            if ($request->has('status')) {
                $session_administrator->update([
                    'status' => $validate_request['status'],
                ]);
            }

            return self::apiResponse(true, "Mis à jour du CA avec suucès", $session_administrator, 200);
        } catch (ValidationException $e) {
            return self::apiResponse(false, "Echec de la mise à jour du CA", $e->errors(), 422);
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
