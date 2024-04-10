<?php

namespace App\Http\Controllers\API\V1\Gourvernance\GeneralMeeting;

use App\Http\Controllers\Controller;
use App\Http\Requests\AttendanceListGeneralMeeting\StoreAttendanceListGeneralMeetingRequest;
use App\Http\Requests\AttendanceListGeneralMeeting\UpdateAttendanceListGeneralMeetingRequest;
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
    public function index(Request $request)
    {
        $attendance_list_general_meeting = AttendanceListGeneralMeeting::where('general_meeting_id', $request->general_meeting_id)->get();
        return api_response(true, "Liste de présence", $attendance_list_general_meeting , 200);
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
     * Update the specified resource in storage.
     */
    public function update(AttendanceListGeneralMeeting $attendanceListGeneralMeeting)
    {
        try {

            $this->attendance->update($attendanceListGeneralMeeting);
            return api_response(true, "Liste de présence mis à jour avec succès", '', 200);
        } catch (ValidationException $e) {

            return api_response(false, "Echec de la mise à jour de la liste de présence", $e->errors(), 422);
        }
    }
}
