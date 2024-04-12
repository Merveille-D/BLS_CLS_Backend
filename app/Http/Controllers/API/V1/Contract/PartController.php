<?php

namespace App\Http\Controllers\API\V1\Contract;

use App\Http\Controllers\Controller;
use App\Http\Requests\PartContract\StorePartRequest;
use App\Models\Contract\Part;
use App\Repositories\Contract\PartRepository;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PartController extends Controller
{
    public function __construct(private PartRepository $part) {

    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $parts = Part::all();
            return api_response(true, 'Liste des parties', $parts);
        }catch (\Exception $e) {
            return api_response(false, "Echec de la récupération des parties", $e->getMessage(), 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePartRequest $request)
    {
        try {
            $part = $this->part->store($request);
            return api_response(true, 'Partie ajouté avec succès', $part, 201);
        }catch (ValidationException $e) {
                return api_response(false, "Echec de l'ajout de la partie", $e->errors(), 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Part $part)
    {
        try {
            return api_response(true, "Information de la partie", $part, 200);
        }catch( ValidationException $e ) {
            return api_response(false, "Echec de la récupération des infos de la partie", $e->errors(), 422);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Part $part)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Part $part)
    {
        //
    }
}
