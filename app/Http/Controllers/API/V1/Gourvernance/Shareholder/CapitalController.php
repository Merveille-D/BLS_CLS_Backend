<?php

namespace App\Http\Controllers\API\V1\Gourvernance\Shareholder;

use App\Http\Controllers\Controller;
use App\Http\Requests\Capital\StoreCapitalRequest;
use App\Http\Requests\Capital\UpdateCapitalRequest;
use App\Models\Shareholder\Capital;
use App\Repositories\Shareholder\CapitalRepository;
use Illuminate\Validation\ValidationException;

class CapitalController extends Controller
{
    public function __construct(private CapitalRepository $capital) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $capitals = Capital::all();

        return api_response(true, 'Historique des capitaux', $capitals, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCapitalRequest $request)
    {
        try {
            $capital = $this->capital->store($request->all());

            return api_response(true, "Succès de l'enregistrement du capital", $capital, 200);
        } catch (ValidationException $e) {
            return api_response(false, "Echec de l'enregistrement du capital", $e->errors(), 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Capital $capital)
    {
        try {
            return api_response(true, 'Infos du capital', $capital, 200);
        } catch (ValidationException $e) {
            return api_response(false, 'Echec de la récupération des infos du capital', $e->errors(), 422);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCapitalRequest $request, Capital $capital)
    {
        try {
            $this->capital->update($capital, $request->all());

            return api_response(true, 'Mis à jour du texte avec succès', $capital, 200);
        } catch (ValidationException $e) {

            return api_response(false, 'Echec de la mise à jour', $e->errors(), 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Capital $capital)
    {
        try {
            $capital->delete();

            return api_response(true, 'Succès de la suppression du capital', null, 200);
        } catch (ValidationException $e) {
            return api_response(false, 'Echec de la supression du capital', $e->errors(), 422);
        }
    }
}
