<?php

namespace App\Http\Controllers\API\V1\Litigation;

use App\Enums\Litigation\LitigationType;
use App\Http\Controllers\Controller;
use App\Models\Litigation\LitigationDocument;
use App\Repositories\Litigation\LitigationRepository;
use Illuminate\Http\Request;

class LitigationDocumentController extends Controller
{
    /**
     * __construct
     *
     * @param  mixed $resourceRepo
     * @return void
     */
    public function __construct(private LitigationRepository $litigationRepo) {

    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return api_response(true, 'Liste des categories de documents', $data = $this->litigationRepo->getResources($type = LitigationType::DOCUMENT));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $data = $this->litigationRepo->addResource($request, $type = LitigationType::DOCUMENT);

            return api_response($success = true, 'Ressource ajoutée avec succès', $data);
        } catch (\Throwable $th) {
            return api_error($success = false, 'Une erreur s\'est produite lors de l\'operation', ['errors' => ['server' => $th->getMessage()]]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(LitigationDocument $litigationDocument)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LitigationDocument $litigationDocument)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LitigationDocument $litigationDocument)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LitigationDocument $litigationDocument)
    {
        //
    }
}
