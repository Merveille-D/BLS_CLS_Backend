<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AddRoleRequest;
use App\Models\Auth\Permission;
use App\Models\Auth\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return api_response(true, 'Roles retrieved successfully', Role::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddRoleRequest $request)
    {
        try {
            $role = Role::create(['name' => $request->name, 'guard_name' => 'web']);
            //assign permissions
            if($request['permissions'])
                $role->givePermissionTo(Permission::whereIn('id', $request['permissions'])->get());

            return api_response(true, 'Role created successfully', $role, 201);
        } catch (\Throwable $th) {
            return api_error(false, $th->getMessage(), ['server' => $th->getMessage() ]);
        }

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
