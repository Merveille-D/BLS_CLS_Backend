<?php

namespace App\Http\Controllers\API\V1\Guarantee\ConventionnalHypothecs;

use App\Http\Controllers\Controller;
use App\Http\Requests\Hypothec\StoreSignificationRequest;
use App\Repositories\HypothecRepository;
use Essa\APIToolKit\Api\ApiResponse;
use Illuminate\Http\Request;

class ConventionnalHypothecController extends Controller
{
    use ApiResponse;
    public function __construct(private HypothecRepository $hypothecRepo) {
        
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
    public function store(StoreSignificationRequest $request)
    {
        $this->hypothecRepo->initFormalizationProcess($request);
        return $this->responseSuccess('Formalization initied successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
}
