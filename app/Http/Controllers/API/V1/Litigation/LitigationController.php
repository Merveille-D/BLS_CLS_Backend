<?php

namespace App\Http\Controllers\API\V1\Litigation;

use App\Http\Controllers\Controller;
use App\Http\Requests\Litigation\AddLitigationRequest;
use App\Http\Resources\Litigation\LitigationResource;
use App\Models\Litigation\Litigation;
use App\Repositories\Litigation\LitigationRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LitigationController extends Controller
{
    /**
     * __construct
     *
     * @param  mixed $litigationRepo
     * @return void
     */
    public function __construct(private LitigationRepository $litigationRepo) {}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return api_response(true, 'Liste des parties', $data = $this->litigationRepo->getList(request()));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddLitigationRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = $this->litigationRepo->add($request);
            DB::commit();
            return api_response($success = true, 'Contentieux ajouté avec succès', $data);
        } catch (\Throwable $th) {
            DB::rollBack();
            return api_error($success = false, 'Une erreur s\'est produite lors de l\'operation', ['server' => $th->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Litigation $litigation)
    {
        return api_response(true, 'Contentieux recuperé', $data = new LitigationResource($litigation));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Litigation $litigation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Litigation $litigation)
    {
        //
    }
}
