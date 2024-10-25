<?php

namespace App\Http\Controllers\API\V1\Litigation;

use App\Http\Controllers\Controller;
use App\Http\Requests\Litigation\AddPartyRequest;
use App\Models\Litigation\LitigationParty;
use App\Repositories\Litigation\PartyRepository;
use Illuminate\Http\Request;
use Throwable;

class LitigationPartyController extends Controller
{
    /**
     * __construct
     *
     * @param  mixed  $partyRepo
     * @return void
     */
    public function __construct(private PartyRepository $partyRepo) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return api_response(true, 'Liste des parties', $data = $this->partyRepo->getList(request()));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddPartyRequest $request)
    {
        try {
            $data = $this->partyRepo->add($request);

            return api_response($success = true, 'Parti ajouté avec succès', $data);
        } catch (Throwable $th) {
            return api_error($success = false, 'Une erreur s\'est produite lors de l\'operation', ['errors' => ['server' => $th->getMessage()]]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(LitigationParty $litigationParty)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LitigationParty $litigationParty)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LitigationParty $litigationParty)
    {
        //
    }
}
