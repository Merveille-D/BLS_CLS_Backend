<?php

namespace App\Http\Controllers;

use App\Http\Requests\Administrator\StorePartRequest;
use App\Models\Contract\Part;
use App\Repositories\PartRepository;
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
        //
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
        //
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
