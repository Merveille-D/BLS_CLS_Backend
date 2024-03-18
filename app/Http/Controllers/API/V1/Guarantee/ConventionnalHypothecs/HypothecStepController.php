<?php

namespace App\Http\Controllers\API\V1\Guarantee\ConventionnalHypothecs;

use App\Http\Controllers\Controller;
use App\Repositories\HypothecRepository;
use Essa\APIToolKit\Api\ApiResponse;
use Illuminate\Http\Request;

class HypothecStepController extends Controller
{
    use ApiResponse;

    public function __construct(private HypothecRepository $hypothecRepo) {
        
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->responseSuccess(null, $this->hypothecRepo->getSteps());
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
