<?php

namespace App\Http\Controllers\API\V1\Litigation;

use App\Enums\Litigation\LitigationType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Litigation\AddNatureRequest;
use App\Repositories\Litigation\LitigationRepository;
use Illuminate\Http\Request;
use Throwable;

class JurisdictionController extends Controller
{
    /**
     * __construct
     *
     * @param  mixed  $resourceRepo
     * @return void
     */
    public function __construct(private LitigationRepository $litigationRepo) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return api_response(true, 'Liste des juridictions', $data = $this->litigationRepo->getResources($type = LitigationType::JURISDICTION));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddNatureRequest $request)
    {
        try {
            $data = $this->litigationRepo->addResource($request, $type = LitigationType::JURISDICTION);

            return api_response($success = true, 'Ressource ajoutée avec succès', $data);
        } catch (Throwable $th) {
            return api_error($success = false, 'Une erreur s\'est produite lors de l\'operation', ['errors' => ['server' => $th->getMessage()]]);
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
}
