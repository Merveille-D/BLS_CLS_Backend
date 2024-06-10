<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AddRoleRequest;
use App\Http\Resources\User\RoleResource;
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
        return api_response(true, 'Roles retrieved successfully', RoleResource::collection(Role::all()));
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
        return api_response(true, 'Role retrieved successfully', new RoleResource(Role::find($id)));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $role = Role::find($id);
            $role->update($request->all());
            //assign permissions
            if($request['permissions'])
                $role->syncPermissions(Permission::whereIn('id', $request['permissions'])->get());

            return api_response(true, 'Role updated successfully', new RoleResource($role));
        } catch (\Throwable $th) {
            return api_error(false, $th->getMessage(), ['server' => $th->getMessage() ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $role = Role::find($id);
            $role->delete();
            return api_response(true, 'Role deleted successfully');
        } catch (\Throwable $th) {
            return api_error(false, $th->getMessage(), ['server' => $th->getMessage() ]);
        }
    }
}
