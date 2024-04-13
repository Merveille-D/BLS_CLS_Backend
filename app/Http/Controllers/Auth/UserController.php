<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use App\Repositories\Authentication\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function __construct(private UserRepository $userRepo)
    {
    }


    public function register(RegisterRequest $request)
    {
        try {
            $user = $this->userRepo->add($request);

            return api_response(true, 'Utilisateur crée avec succès', $user, 201);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
        }
    }

    public function login(LoginRequest $request)
    {
        try {
            $token = $this->userRepo->check($request);

            if ($token === false) {
                return api_response(false, 'Non autorisé', '', 401);
            }
            return api_response(true, 'Utilisateur connecté avec succès', [
                'access_token' => $token,
            ]);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return api_error(false, $th->getMessage(), ['server' => $th->getMessage() ]);
        }
    }

    public function logout()
    {
        try {
            $this->userRepo->logout();

            return api_response(true, 'Utilisateur déconnecté avec succès');
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return api_error(false, $th->getMessage(), ['serveur' => $th->getMessage() ]);
        }
    }
}
