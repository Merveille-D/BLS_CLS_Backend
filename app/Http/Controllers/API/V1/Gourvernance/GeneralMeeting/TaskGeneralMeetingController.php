<?php

namespace App\Http\Controllers\API\V1\Gourvernance\GeneralMeeting;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskGeneralMeeting\StoreTaskGeneralMeetingRequest;
use App\Http\Requests\TaskGeneralMeeting\UpdateTaskGeneralMeetingRequest;
use App\Models\Gourvernance\GeneralMeeting\TaskGeneralMeeting;
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
        return api_response(true, "Liste des taches de l'AG", $task_general_meetings, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskGeneralMeetingRequest $request)
    {
        try {
            $task_general_meeting = $this->task->store($request);
            return api_response(true, "Succès de l'enregistrement de la tache", $task_general_meeting, 200);
        }catch (ValidationException $e) {
                return api_response(false, "Echec de l'enregistrement de la tache", $e->errors(), 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(TaskGeneralMeeting $taskGeneralMeeting)
    {
        try {

            return api_response(true, "Information de l'AG", [], 200);
        }catch( ValidationException $e ) {
            return api_response(false, "Echec de la récupération des infos de la tache", $e->errors(), 422);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskGeneralMeetingRequest $request, TaskGeneralMeeting $taskGeneralMeeting)
    {
        try {
            $taskGeneralMeeting = $this->task->update($request);
            return api_response(true, "Succès de l'enregistrement de la tache", $taskGeneralMeeting, 200);
        }catch (ValidationException $e) {
                return api_response(false, "Echec de l'enregistrement de la tache", $e->errors(), 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TaskGeneralMeeting $taskGeneralMeeting)
    {
        //
    }
}
