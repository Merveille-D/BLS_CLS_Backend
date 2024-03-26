<?php

namespace App\Http\Controllers\API\V1\Gourvernance\BordDirectors\Sessions;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskSessionAdministratorRequest;
use App\Http\Requests\UpdateTaskSessionAdministratorRequest;
use App\Models\Gourvernance\BoardDirectors\Sessions\TaskSessionAdministrator;
use App\Models\Gourvernance\GeneralMeeting\TaskGeneralMeeting;
use App\Models\Utility;
use App\Repositories\TaskSessionAdministratorRepository;
use Illuminate\Validation\ValidationException;

class TaskSessionAdministratorController extends Controller
{

    public function __construct(private TaskSessionAdministratorRepository $task) {

    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $task_general_meetings = TaskGeneralMeeting::all();
        return Utility::apiResponse(true, "Liste des Taches AG", $task_general_meetings, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskSessionAdministratorRequest $request)
    {
        try {
            $task_general_meeting = $this->task->store($request);
            return Utility::apiResponse(true, "Succès de l'enregistrement de l'AG", $task_general_meeting, 200);
        }catch (ValidationException $e) {
                return Utility::apiResponse(false, "Echec de l'enregistrement de l'AG", $e->errors(), 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(TaskSessionAdministrator $taskSessionAdministrator)
    {
        try {

            return Utility::apiResponse(true, "Information de l'AG", [], 200);
        }catch( ValidationException $e ) {
            return Utility::apiResponse(false, "Echec de la récupération des infos de l'AG", $e->errors(), 422);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TaskSessionAdministrator $taskSessionAdministrator)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskSessionAdministratorRequest $request, TaskSessionAdministrator $taskSessionAdministrator)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TaskSessionAdministrator $taskSessionAdministrator)
    {
        //
    }
}
