<?php

namespace App\Http\Controllers\API\V1\Gourvernance\BordDirectors\Administrators;

use App\Http\Controllers\Controller;
use App\Models\Gourvernance\BoardDirectors\Administrators\CaAdministrator;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CaAdministratorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ca_administrators = CaAdministrator::with('procedures')->get();
        return self::apiResponse(true, "Liste des Administrateurs du comité", $ca_administrators, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        try {
            $validate_request =  $request->validate([
                // Personne physique
                'firstname' => ['required', 'string'],
                'lastname' => ['required', 'string'],
                'birthday' => ['required', 'date'],
                'birthplace' => ['required', 'string'],
                'age' => ['required', 'numeric'],
                'nationality' => ['required', 'string'],
                'address' => ['required', 'string'],
                'grade' => ['required', 'string'],
                'quality' => ['required', 'string'],

                // Personne morale
                'denomination' => ['string'],
                'siege' => ['string'],
                'representant' => ['string'],

                'is_uemoa' => ['required', 'string'],
            ]);

            $ca_administrator = CaAdministrator::create([
                'firstname' => $validate_request['firstname'],
                'lastname' => $validate_request['lastname'],
                'birthday' => $validate_request['birthday'],
                'birthplace' => $validate_request['birthplace'],
                'age' => $validate_request['age'],
                'nationality' => $validate_request['nationality'],
                'address' => $validate_request['address'],
                'grade' => $validate_request['grade'],
                'quality' => $validate_request['quality'],

                'denomination' => $validate_request['denomination'] ?? null,
                'siege' => $validate_request['siege'] ?? null,
                'representant' => $validate_request['representant'] ?? null,

                'is_uemoa' => $validate_request['is_uemoa'] ?? null,
            ]);

            $ca_administrator = $ca_administrator->load('procedures');

            return self::apiResponse(true, "Succès de l'enregistrement de l'Administrateur", $ca_administrator, 200);
        }catch (ValidationException $e) {
                return self::apiResponse(false, "Echec de l'enregistrement de l'Administrateur", $e->errors(), 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(CaAdministrator $ca_administrator)
    {
        try {

            $ca_administrator = $ca_administrator->load('procedures');

            return self::apiResponse(true, "Information de l'Administrateur", $ca_administrator, 200);
        }catch( ValidationException $e ) {
            return self::apiResponse(false, "Echec de la récupération des infos de l'Administrateur", $e->errors(), 422);
        }
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

    public static function apiResponse($success, $message, $data = [], $status)
    {
        $response = response()->json([
            'success' => $success,
            'message' => $message,
            'body' => $data
        ], $status);
        return $response;
    }
}
