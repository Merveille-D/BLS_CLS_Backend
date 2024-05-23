<?php

namespace App\Http\Controllers\API\V1\Litigation;

use App\Http\Controllers\Controller;
use App\Http\Requests\Litigation\AddLitigationRequest;
use App\Http\Requests\Litigation\AssignUserRequest;
use App\Http\Requests\Litigation\UpdateAmountRequest;
use App\Http\Requests\Litigation\UpdateLitigationRequest;
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
        return api_response(true, 'Liste des contentieux', $data = $this->litigationRepo->getList(request()));
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
    public function show($litigation)
    {
        return api_response(true, 'Contentieux recuperé', $data = $this->litigationRepo->getByIdWithDocuments($litigation));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Litigation $litigation)
    {
        //
    }
    /**
     * Update the specified resource in storage.
     */
    public function updateLitigation(UpdateLitigationRequest $request, $litigation)
    {
        try {
            DB::beginTransaction();
            $data = $this->litigationRepo->edit($litigation, $request);
            DB::commit();
            return api_response($success = true, 'Contentieux modifié avec succès', $data);
        } catch (\Throwable $th) {
            DB::rollBack();
            return api_error($success = false, 'Une erreur s\'est produite lors de l\'operation', ['server' => $th->getMessage()]);
        }
    }
    /**
     * Update the specified resource in storage.
     */
    public function assignUser(AssignUserRequest $request, $litigation)
    {
        try {
            $data = $this->litigationRepo->assign($litigation, $request);
            return api_response($success = true, 'Contentieux modifié avec succès', $data);
        } catch (\Throwable $th) {
            return api_error($success = false, 'Une erreur s\'est produite lors de l\'operation', ['server' => $th->getMessage()]);
        }
    }

    /**
     * Update the estimated amount field.
     */
    public function updateAmount(UpdateAmountRequest $request, $litigation)
    {
        try {
            $data = $this->litigationRepo->updateAmount($litigation, $request);
            return api_response($success = true, 'Provisions ajoutées  avec succès', $data);
        } catch (\Throwable $th) {
            return api_error($success = false, 'Une erreur s\'est produite lors de l\'opération', ['server' => $th->getMessage()]);
        }
    }
    /**
     * Update the estimated amount field.
     */
    public function archive(Request $request, $litigation)
    {
        try {
            $data = $this->litigationRepo->archive($litigation);
            return api_response($success = true, 'Archivage effectué avec succès', $data);
        } catch (\Throwable $th) {
            return api_error($success = false, 'Une erreur s\'est produite lors de l\'opération', ['server' => $th->getMessage()]);
        }
    }

    /**
        * Update the added amount field.
        */
    public function updateAddedAmount(UpdateAmountRequest $request, $litigation)
    {
        try {
            $data = $this->litigationRepo->updateAddedAmount($litigation, $request->amount);
            return api_response($success = true, 'Montant ajouté mis à jour avec succès', $data);
        } catch (\Throwable $th) {
            return api_error($success = false, 'Une erreur s\'est produite lors de l\'opération', ['server' => $th->getMessage()]);
        }
    }

    /**
     * Update the remaining amount field.
     */
    public function updateRemainingAmount(UpdateAmountRequest $request, $litigation)
    {
        try {
            $data = $this->litigationRepo->updateRemainingAmount($litigation, $request->amount);
            return api_response($success = true, 'Montant restant mis à jour avec succès', $data);
        } catch (\Throwable $th) {
            return api_error($success = false, 'Une erreur s\'est produite lors de l\'opération', ['server' => $th->getMessage()]);
        }
    }

    /**
     * cumulation of provisions

    */
    public function provisionStats()
    {
        try {
            $data = $this->litigationRepo->provisionStats();
            return api_response($success = true, 'Statistiques des provisions', $data);
        } catch (\Throwable $th) {
            return api_error($success = false, 'Une erreur s\'est produite lors de l\'opération', ['server' => $th->getMessage()]);
        }
    }

    /**
     * Generate pdf
     */
    public function generatePdf($litigation)
    {
        try {
            $data = $this->litigationRepo->generatePdf($litigation);
            return $data;
        } catch (\Throwable $th) {
            return api_error($success = false, 'Une erreur s\'est produite lors de l\'opération', ['server' => $th->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Litigation $litigation)
    {
        //
    }
}
