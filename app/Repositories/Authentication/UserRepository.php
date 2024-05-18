<?php
namespace App\Repositories\Authentication;

use App\Http\Resources\User\UserResource;
use App\Models\Auth\Role;
use App\Models\User;
use Illuminate\Http\Resources\Json\ResourceCollection;
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
    ) {
    }

    public function getList($request) : ResourceCollection {
        $search = $request->search;
        $query = $this->user_model
                ->when(!blank($search), function($qry) use($search) {
                    $qry->where('name', 'like', '%'.$search.'%');
                })
                ->paginate();


        return UserResource::collection($query);
    }

    public function add($request) {
        $user = User::create([
            'firstname' => $request['firstname'],
            'lastname' => $request['lastname'],
            'email' => $request['email'],
            'username' => $request['username'],
            'password' => Hash::make('password'),
            'country_id' => $request['country_id'],
        ]);

        //assign role
        $role = Role::find($request['role_id']);
        $user->assignRole($role);

        return $user;
    }

    public function check($request) {
        $user = User::where('email',$request['email'])->first();

        if(!$user || !Hash::check($request['password'], $user->password)){
            return false;
        }
        return $token = $user->createToken($user->name.'-AuthToken')->plainTextToken;
    }

    public function logout() {
        auth()->user()->tokens()->delete();
    }

    function delete($user_id) {
        $user = $this->user_model->findOrFail($user_id);
        $user->delete();
    }
}
