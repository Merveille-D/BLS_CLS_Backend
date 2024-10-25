<?php

namespace App\Repositories\Authentication;

use App\Http\Resources\User\UserResource;
use App\Models\Auth\Role;
use App\Models\User;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserRepository
{
    /**
     * __construct
     *
     * @return void
     */
    public function __construct(
        private User $user_model,
    ) {}

    public function getList($request): ResourceCollection
    {
        $search = $request->search;
        $query = $this->user_model
            ->when(! blank($search), function ($qry) use ($search) {
                $qry->where('name', 'like', '%' . $search . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(DEFAULT_DATA_LIMIT);

        return UserResource::collection($query);
    }

    public function add($request)
    {
        $user = User::create([
            'firstname' => $request['firstname'],
            'lastname' => $request['lastname'],
            'email' => $request['email'],
            'username' => $request['username'],
            'password' => Hash::make('password'),
            'subsidiary_id' => $request['subsidiary_id'],
        ]);

        //assign role
        $role = Role::find($request['role_id']);

        $user->assignRole($role);

        return new UserResource($user);
    }

    public function check($request)
    {
        $user = User::where('email', $request['email'])->first();

        if (! $user || ! Hash::check($request['password'], $user->password)) {
            return false;
        }

        return $token = $user->createToken($user->name . '-AuthToken')->plainTextToken;
    }

    public function authenticate($credentials)
    {
        $auth_mode = config('auth.auth_mode');
        $data = [];

        if ($auth_mode == 'database') {
            $user = User::where('username', $credentials['uid'])->first();

            if (! $user || ! Hash::check($credentials['password'], $user->password)) {
                return ['error' => 'Unauthorized'];
            }
            $token = $user->createToken($user->name . '-AuthToken')->plainTextToken;

            $data = [
                'access_token' => $token,
                'user' => new UserResource($user),
            ];

        } elseif ($auth_mode == 'ldap') {
            if (Auth::guard('ldap')->attempt($credentials)) {

                $user = Auth::guard('ldap')->user();
                // Generate Sanctum token
                $user = $this->user_model->where('username', $user->uid)->first();
                $token = $user->createToken($user->username . '-AuthToken')->plainTextToken;

                $data = [
                    'access_token' => $token,
                    'user' => new UserResource($user),
                ];
            }
        }

        return $data;

    }

    public function logout()
    {
        auth()->user()->tokens()->delete();
    }

    public function delete($user_id)
    {
        $user = $this->user_model->findOrFail($user_id);
        $user->delete();
    }
}
