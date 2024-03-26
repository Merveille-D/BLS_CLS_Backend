<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskGeneralMeetingRequest;
use App\Http\Requests\UpdateTaskGeneralMeetingRequest;
use App\Models\Gourvernance\GeneralMeeting\TaskGeneralMeeting;
use App\Models\Utility;
use App\Repositories\TaskGeneralMeetingRepository;
use Illuminate\Validation\ValidationException;

class TaskGeneralMeetingController extends Controller
{
    public function __construct(private TaskGeneralMeetingRepository $task) {

    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $task_general_meetings = TaskGeneralMeeting::all();
        return Utility::apiResponse(true, "Liste des AG", $task_general_meetings, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskGeneralMeetingRequest $request)
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
    public function show(TaskGeneralMeeting $taskGeneralMeeting)
    {
        try {

            return Utility::apiResponse(true, "Information de l'AG", [], 200);
        }catch( ValidationException $e ) {
            return Utility::apiResponse(false, "Echec de la récupération des infos de l'AG", $e->errors(), 422);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskGeneralMeetingRequest $request, TaskGeneralMeeting $taskGeneralMeeting)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TaskGeneralMeeting $taskGeneralMeeting)
    {
        //
    }
}
