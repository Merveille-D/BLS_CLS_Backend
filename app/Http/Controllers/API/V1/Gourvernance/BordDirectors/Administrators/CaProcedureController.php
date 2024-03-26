<?php

namespace App\Http\Controllers\API\V1\Gourvernance\BordDirectors\Administrators;

use App\Http\Controllers\Controller;
use App\Models\FileUpload;
use App\Models\Gourvernance\BoardDirectors\Administrators\CaProcedure;
use App\Models\Gourvernance\BoardDirectors\Administrators\CaTypeDocument;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CaProcedureController extends Controller
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
            $validate_request =  $request->validate([
                'send_date' => ['required', 'date'],
                'ca_administrator_id' => ['required', 'numeric'],
                'files' => ['required', 'array'],
            ]);


            $files = $validate_request['files'];

            foreach ($files as $key => $file) {

                CaProcedure::create([
                    'send_date' => $validate_request['send_date'],
                    'file' => FileUpload::uploadFile($file['file'],'ca_procedure_files'),
                    'ca_type_document_id' => $key,
                    'ca_administrator_id' => $validate_request['ca_administrator_id']
                ]);
            }

            return self::apiResponse(true, "Succès de l'enregistrement de la procédure", [], 200);
        }catch (ValidationException $e) {
                return self::apiResponse(false, "Echec de l'enregistrement de la procédure", $e->errors(), 422);
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function getCaTypeDocument() {

        $ca_type_documents = CaTypeDocument::all();
        return self::apiResponse(true, "Documents exigés pour une procédure", $ca_type_documents, 200);
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
