<?php

namespace App\Http\Controllers\API\V1\Litigation;

use App\Http\Controllers\Controller;
use App\Http\Resources\Litigation\LawyerResource;
use App\Models\Litigation\LitigationLawyer;
use App\Repositories\Litigation\LawyerRepository;
use Illuminate\Http\Request;

class LitigationLawyerController extends Controller
{
    public function __construct(private LawyerRepository $lawyerRepo) {

    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return api_response(true, 'Liste des avocats', $data = $this->lawyerRepo->getList(request()));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(LitigationLawyer $litigationLawyer)
    {
        return api_response(true, 'Un avocat', $data = new LawyerResource($litigationLawyer));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LitigationLawyer $litigationLawyer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LitigationLawyer $litigationLawyer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LitigationLawyer $litigationLawyer)
    {
        //
    }
}
