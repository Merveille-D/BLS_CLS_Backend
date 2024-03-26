<?php
namespace App\Repositories;

use App\Models\FileUpload;
use App\Models\Gourvernance\BoardDirectors\Sessions\SessionAdministrator;
use App\Models\Utility;
use Illuminate\Validation\ValidationException;

class SessionAdministratorRepository
{
    public function __construct(private SessionAdministrator $session) {

    }

    /**
     * @param Request $request
     *
     * @return SessionAdministrator
     */
    public function store($request) {
        $request['reference'] = 'CA-' . date('m') . '-' . date('Y');
        $session_administrator = $this->session->create($request->all());
        $session_administrator->status = 'pending';

        return $session_administrator;
    }

    /**
     * @param Request $request
     *
     * @return SessionAdministrator
     */
    public function attachement($request) {
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

        return $session_administrator;
    }
}
