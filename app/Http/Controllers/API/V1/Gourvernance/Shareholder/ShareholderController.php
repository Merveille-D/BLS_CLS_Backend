<?php

namespace App\Http\Controllers\API\V1\Gourvernance\Shareholder;

use App\Http\Controllers\Controller;
use App\Http\Requests\Shareholder\GeneratePdfCertificatShareholderRequest;
use App\Http\Requests\Shareholder\ListShareholderRequest;
use App\Http\Requests\Shareholder\StoreShareholderRequest;
use App\Http\Requests\Shareholder\UpdateShareholderRequest;
use App\Models\Shareholder\Shareholder;
use App\Repositories\Shareholder\ShareholderRepository;
use Illuminate\Validation\ValidationException;

class ShareholderController extends Controller
{

    public function __construct(private ShareholderRepository $shareholder) {

    }

    /**
     * Display a listing of the resource.
     */
    public function index(ListShareholderRequest $request)
    {
        $shareholders = Shareholder::when(request('type') !== null, function($query) {
                $query->where('type', request('type'));
            })->get();

        return api_response(true, "Liste des actionnaires", $shareholders, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreShareholderRequest $request)
    {
        try {
            $shareholder = $this->shareholder->store($request->all());
            return api_response(true, "Succès de l'enregistrement de l'actionnaires", $shareholder, 200);
        }catch (ValidationException $e) {
                return api_response(false, "Echec de l'enregistrement de l'actionnaires", $e->errors(), 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Shareholder $shareholder)
    {
        try {
            return api_response(true, "Infos de l'actionnaire", $shareholder, 200);
        }catch( ValidationException $e ) {
            return api_response(false, "Echec de la récupération des infos de l'actionnaire", $e->errors(), 422);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateShareholderRequest $request, Shareholder $shareholder)
    {
        try {
            $this->shareholder->update($shareholder, $request->all());
            return api_response(true, "Mis à jour de l'actionnaire avec succès", $shareholder, 200);
        } catch (ValidationException $e) {

            return api_response(false, "Echec de la mise à jour", $e->errors(), 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Shareholder $shareholder)
    {
        try {
            $shareholder->delete();
            $this->shareholder->updateBankInfo();
            return api_response(true, "Succès de la suppression de l'actionnaire", null, 200);
        }catch (ValidationException $e) {
                return api_response(false, "Echec de la supression de l'actionnaire", $e->errors(), 422);
        }
    }

    public function generatePdfCertificatShareholder(GeneratePdfCertificatShareholderRequest $request)
    {
        try {
            $data = $this->shareholder->generatePdfCertificat($request);
            return $data;
        } catch (\Throwable $th) {
            return api_error($success = false, 'Une erreur s\'est produite lors de l\'opération', ['server' => $th->getMessage()]);
        }
    }
}
