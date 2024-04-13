<?php

namespace App\Http\Controllers\API\V1\Guarantee;

use App\Http\Controllers\Controller;
use App\Models\Guarantee\ConvHypothecStep;
use Illuminate\Http\Request;

class ConvHypothecStepController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ConvHypothecStep::all();
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
    public function show(ConvHypothecStep $convHypothecStep)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ConvHypothecStep $convHypothecStep)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ConvHypothecStep $convHypothecStep)
    {
        //
    }
}
