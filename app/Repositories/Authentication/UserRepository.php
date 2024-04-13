<?php
namespace App\Repositories\Authentication;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRepository
{
    public function add($request) {
        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make('12345678'),
        ]);

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
}
