<?php

namespace App\Http\Controllers\API\V1\Gourvernance\BordDirectors\Sessions;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSessionAdministratorRequest;
use App\Http\Requests\UpdateSessionAdministratorRequest;
use App\Models\FileUpload;
use App\Models\Gourvernance\BoardDirectors\Sessions\SessionAdministrator;
use App\Models\Utility;
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
        $session_administrators = SessionAdministrator::with('fileUploads')->get();
        return Utility::apiResponse(true, "Liste des Sessions", $session_administrators, 200);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSessionAdministratorRequest $request)
    {

        try {
            $request['reference'] = 'CA-' . date('m') . '-' . date('Y');
            $session_administrator = SessionAdministrator::create($request->all());

            $session_administrator->status = 'pending';

            return Utility::apiResponse(true, "Succès de l'enregistrement du CA", $session_administrator, 200);
        } catch (ValidationException $e) {
            return Utility::apiResponse(false, "Echec de l'enregistrement du CA", $e->errors(), 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(SessionAdministrator $session_administrator)
    {
        try {
            $session_administrator->load('fileUploads');
            return Utility::apiResponse(true, "Information du CA", $session_administrator, 200);
        } catch (ValidationException $e) {
            return Utility::apiResponse(false, "Echec de la récupération des infos du CA", $e->errors(), 422);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSessionAdministratorRequest $request, SessionAdministrator $session_administrator)
    {
        //
    }

    public function attachment(UpdateSessionAdministratorRequest $request)
    {
        try {

            $session_administrator = SessionAdministrator::find($request->session_administrator_id);

            $files = $request->docs['files'];
            $others_files = $request->docs['others_files'];

            foreach ($files as $fieldName => $file) {
                $session_administrator->update([
                    $fieldName => FileUpload::uploadFile($file, 'ag_documents'),
                    SessionAdministrator::DATE_FILE_FIELD[$fieldName] => now(),
                ]);
            }

            foreach ($others_files as $file) {
                $fileUpload = new FileUpload();

                $fileUpload->name = $file['name'];
                $fileUpload->file = FileUpload::uploadFile($file['file'], 'ca_documents');
                $fileUpload->status = $session_administrator->status;

                $session_administrator->fileUploads()->save($fileUpload);
            }

            return Utility::apiResponse(true, "Mis à jour du CA avec suucès", $session_administrator, 200);

        }catch( ValidationException $e ) {
            return Utility::apiResponse(false, "Echec de la mise à jour du CA ", $e->errors(), 422);
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
