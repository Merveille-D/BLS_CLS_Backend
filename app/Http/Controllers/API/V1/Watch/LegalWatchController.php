<?php

namespace App\Http\Controllers\API\V1\Watch;

use App\Http\Controllers\Controller;
use App\Http\Requests\Watch\AddWatchRequest;
use App\Http\Resources\Watch\LegalWatchResource;
use App\Models\Watch\LegalWatch;
use App\Repositories\Watch\LegalWatchRepository;
use Illuminate\Http\Request;
use Throwable;

class LegalWatchController extends Controller
{
    public function __construct(private LegalWatchRepository $watchRepo) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return api_response(true, 'Liste des veilles juridiques', $data = $this->watchRepo->getList(request()));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddWatchRequest $request)
    {
        try {
            $data = $this->watchRepo->add($request);

            return api_response($success = true, 'Veille ajoutée avec succès', $data);
        } catch (Throwable $th) {
            return api_error($success = false, 'Une erreur s\'est produite lors de l\'operation', ['server' => $th->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(LegalWatch $legalWatch)
    {
        return api_response(true, 'Veille juridique recuperé', $data = new LegalWatchResource($legalWatch));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LegalWatch $legalWatch)
    {
        try {
            $legalWatch->update($request->all());

            return api_response($success = true, 'Veille modifiée avec succès', $data = new LegalWatchResource($legalWatch));
        } catch (Throwable $th) {
            return api_error($success = false, 'Une erreur s\'est produite lors de l\'opération', ['server' => $th->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LegalWatch $legalWatch)
    {
        try {
            $legalWatch->delete();

            return api_response($success = true, 'Veille supprimée avec succès', $data = []);
        } catch (Throwable $th) {
            return api_error($success = false, 'Une erreur s\'est produite lors de l\'opération', ['server' => $th->getMessage()]);
        }
    }

    /**
     * generate pdf
     */
    public function generatePdf($recovery)
    {
        try {
            $data = $this->watchRepo->generatePdf($recovery);

            return $data;
        } catch (Throwable $th) {
            return api_error($success = false, 'Une erreur s\'est produite lors de l\'opération', ['server' => $th->getMessage()]);
        }
    }
}
