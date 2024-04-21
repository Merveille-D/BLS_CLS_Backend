<?php

namespace App\Http\Controllers\API\V1\Recovery;

use App\Http\Controllers\Controller;
use App\Http\Requests\Recovery\AddTaskRequest;
use App\Http\Requests\Recovery\InitRecoveryRequest;
use App\Http\Requests\Recovery\UpdateProcessRequest;
use App\Models\Recovery\Recovery;
use App\Repositories\Recovery\RecoveryRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RecoveryController extends Controller
{
    public function __construct(private RecoveryRepository $recoveryRepo)
    {

    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return api_response(true, 'Liste de tous les recouvrements', $data = $this->recoveryRepo->getList(request()));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(InitRecoveryRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = $this->recoveryRepo->init($request, null);
            DB::commit();
            return api_response($success = true, 'Recouvrement initié avec succès', $data);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th->getMessage());
            return api_error($success = false, 'Une erreur s\'est produite lors de l\'operation', ['server' => $th->getMessage()]);
        }
    }

    public function updateProcess(UpdateProcessRequest $request,Recovery $recovery)
    {
        try {
            DB::beginTransaction();
            $data = $this->recoveryRepo->updateProcess($request, $recovery);
            DB::commit();
            return api_response($success = true, 'Recouvrement mise à jour avec succès', $data);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th->getMessage());
            return api_error($success = false, 'Une erreur s\'est produite lors de l\'operation', ['server' => $th->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return api_response(true, 'Recouvrement recuperée', $data = $this->recoveryRepo->findById($id));
    }

    /**
     * Display the all steps for a recovery.
     */
    public function showSteps(string $id)
    {
        return api_response(true, 'Etapes recuperées', $data = $this->recoveryRepo->getSteps($id, request()));
    }

    /**
     * Display the specified resource.
     */
    public function showOneStep(string $recovery_id, string $step_id)
    {
        return api_response(true, 'Etape recuperée', $data = $this->recoveryRepo->getOneStep($recovery_id, $step_id));
    }


    public function addTask(AddTaskRequest $request, $recovery) {
        try {
            DB::beginTransaction();
            $data = $this->recoveryRepo->addNewTask($request, $recovery);
            DB::commit();
            return api_response($success = true, 'Tache mise à jour avec succès', $data);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th->getMessage());
            return api_error($success = false, 'Une erreur s\'est produite lors de l\'operation', ['server' => $th->getMessage()]);
        }
    }

    public function updateTask(AddTaskRequest $request, $recovery, $task) {
        try {
            DB::beginTransaction();
            $data = $this->recoveryRepo->updateTask($request, $recovery, $task);
            DB::commit();
            return api_response($success = true, 'Tache mise à jour avec succès', $data);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th->getMessage());
            return api_error($success = false, 'Une erreur s\'est produite lors de l\'operation', ['server' => $th->getMessage()]);
        }
    }

    public function completeTask(Request $request, $recovery, $task) {
        try {
            DB::beginTransaction();
            $data = $this->recoveryRepo->completeTask($recovery, $task);
            DB::commit();
            return api_response($success = true, 'Tache terminée avec succès', $data);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th->getMessage());
            return api_error($success = false, 'Une erreur s\'est produite lors de l\'operation', ['server' => $th->getMessage()]);
        }
    }

    public function deleteTask(Request $request, $recovery, $task) {
        try {
            DB::beginTransaction();
            $data = $this->recoveryRepo->deleteTask($recovery, $task);
            DB::commit();
            return api_response($success = true, 'Tache supprimée avec succès', $data);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th->getMessage());
            return api_error($success = false, 'Une erreur s\'est produite lors de l\'operation', ['server' => $th->getMessage()]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Recovery $recovery)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Recovery $recovery)
    {
        //
    }
}
