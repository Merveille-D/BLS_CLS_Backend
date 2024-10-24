<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\Auth\PermissionResource;
use App\Models\Auth\Permission;
use App\Models\Auth\PermissionEntity;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return api_response(true, 'Permissions retrieved successfully', PermissionResource::collection(PermissionEntity::all()));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        //create permission
        $permission = Permission::create(['name' => $request->name]);

        return api_response(true, 'Permission created successfully', $permission, 201);
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
