<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use App\Repositories\Authentication\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function __construct(private UserRepository $userRepo)
    {
        $this->middleware('auth:sanctum')->only('current', 'logout', 'index');
    }

    public function index()
    {
        return api_response(true, 'Liste des utlisateurs', $data = $this->userRepo->getList(request()));
    }

    public function current()
    {
        return api_response(true, 'Utilisateur connecté', new UserResource(auth()->user()));
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

    public function store(RegisterRequest $request)
    {
        try {
            DB::beginTransaction();
            $user = $this->userRepo->add($request);
            DB::commit();
            return api_response(true, 'Utilisateur crée avec succès', $user, 201);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            DB::rollBack();
            return api_error(false, $th->getMessage(), ['server' => $th->getMessage()]);
        }
    }

    /* public function login(LoginRequest $request)
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
 */

    public function login(LoginRequest $request)
    {
        try {
            $credentials = [
                'uid' => $request['username'],
                'password' => $request['password'],
            ];

            $data = $this->userRepo->authenticate($credentials);

            if (!array_key_exists('access_token', $data)) {
                return api_response(false, 'Non autorisé', '', 401);
            }
            return api_response(true, 'Utilisateur connecté avec succès', $data);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return api_error(false, $th->getMessage(), ['server' => $th->getMessage() ]);
        }

        return response()->json(['success' =>false, 'message' => 'Unauthorized'], 401);
    }

    public function logout()
    {
        try {
            $this->userRepo->logout();

            return api_response(true, 'Utilisateur déconnecté avec succès');
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return api_error(false, $th->getMessage(), ['server' => $th->getMessage()]);
        }
    }

    public function destroy(string $id)
    {
        try {
            $this->userRepo->delete($id);

            return api_response(true, 'Utilisateur supprimé avec succès');
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return api_error(false, $th->getMessage(), ['serveur' => $th->getMessage()]);
        }
    }
}
