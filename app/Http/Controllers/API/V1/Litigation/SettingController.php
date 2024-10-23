<?php

namespace App\Http\Controllers\API\V1\Litigation;

use App\Enums\Litigation\LitigationType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Litigation\AddNatureRequest;
use App\Http\Requests\Litigation\AddSettingRequest;
use App\Repositories\Litigation\LitigationRepository;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * __construct
     *
     * @param  mixed $litigationRepo
     * @return void
     */
    public function __construct(private readonly LitigationRepository $litigationRepo) {

    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return api_response(true, 'Liste des resources', $data = $this->litigationRepo->getResources(request()));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddSettingRequest $request)
    {
        try {
            $data = $this->litigationRepo->addResource($request);

            return api_response($success = true, 'Ressource ajoutée avec succès', $data);
        } catch (\Throwable $th) {
            return api_error($success = false, 'Une erreur s\'est produite lors de l\'operation', ['errors' => ['server' => $th->getMessage()]]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($litigationResource)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $litigationResource)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($litigationResource)
    {
        //
    }
}
