<?php

namespace App\Http\Controllers;

use App\Http\Requests\AttendanceListGeneralMeeting\StoreAttendanceListGeneralMeetingRequest;
use App\Http\Requests\GeneralMeeting\UpdateAttachementGeneralMeetingRequest;
use App\Models\Gourvernance\GeneralMeeting\AttendanceListGeneralMeeting;
use App\Repositories\AttendanceListGeneralMeetingRepository;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AttendanceListGeneralMeetingController extends Controller
{
    public function __construct(private AttendanceListGeneralMeetingRepository $attendance) {

    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAttendanceListGeneralMeetingRequest $request)
    {
        try {
            $attendance = $this->attendance->store($request);
            return api_response(true, "Succès de l'enregistrement de la liste de présence", $attendance, 200);
        }catch (ValidationException $e) {
                return api_response(false, "Echec de l'enregistrement de la liste de présence", $e->errors(), 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(AttendanceListGeneralMeeting $attendanceListGeneralMeeting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAttachementGeneralMeetingRequest $request, AttendanceListGeneralMeeting $attendanceListGeneralMeeting)
    {
        try {

            $this->attendance->update($attendanceListGeneralMeeting, $request->all());
            return api_response(true, "Liste de présence mis à jour avec succès", $attendanceListGeneralMeeting, 200);
        } catch (ValidationException $e) {

            return api_response(false, "Echec de la mise à jour de la liste de présence", $e->errors(), 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AttendanceListGeneralMeeting $attendanceListGeneralMeeting)
    {
        //
    }
}
