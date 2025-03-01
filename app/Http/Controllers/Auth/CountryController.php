<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AddCountryRequest;
use App\Models\Auth\Subsidiary;
use Illuminate\Http\Request;
use Throwable;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return api_response(true, 'Liste des filiales', $data = Subsidiary::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddCountryRequest $request)
    {
        try {
            $country = Subsidiary::create([
                'name' => $request->name,
                'address' => $request->address,
                'country' => $request->country,
                'created_by' => auth()->id(),
                // 'code' => strtolower(str_replace(' ', '_', $request->name)),
            ]);

            return api_response(true, 'Filiales crée avec succès', $country, 201);
        } catch (Throwable $th) {
            return api_error(false, $th->getMessage(), ['server' => $th->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return api_response(true, 'Filiale', $data = Subsidiary::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $country = Subsidiary::findOrFail($id);
            $country->update($request->all());

            return api_response(true, 'Filiale modifié avec succès', $country, 200);
        } catch (Throwable $th) {
            return api_error(false, $th->getMessage(), ['server' => $th->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $country = Subsidiary::findOrFail($id);
            $country->delete();

            return api_response(true, 'Filiale supprimé avec succès', $country, 200);
        } catch (Throwable $th) {
            return api_error(false, $th->getMessage(), ['server' => $th->getMessage()]);
        }
    }
}
