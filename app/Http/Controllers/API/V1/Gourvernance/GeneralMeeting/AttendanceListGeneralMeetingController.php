<?php

namespace App\Http\Controllers\API\V1\Gourvernance\GeneralMeeting;

use App\Http\Controllers\Controller;
use App\Http\Requests\AttendanceListGeneralMeeting\AddAttendanceListGeneralMeetingRequest;
use App\Http\Requests\AttendanceListGeneralMeeting\DeleteAttendanceListGeneralMeetingRequest;
use App\Http\Requests\AttendanceListGeneralMeeting\ListAttendanceListGeneralMeetingRequest;
use App\Models\Gourvernance\GeneralMeeting\AttendanceListGeneralMeeting;
use App\Models\Gourvernance\GeneralMeeting\GeneralMeeting;
use App\Repositories\GeneralMeeting\AttendanceListGeneralMeetingRepository;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AttendanceListGeneralMeetingController extends Controller
{
    public function __construct(private AttendanceListGeneralMeetingRepository $attendance) {

    }

    /**
     * Display a listing of the resource.
     */
    public function list(ListAttendanceListGeneralMeetingRequest $request)
    {
        $attendance_list_general_meeting = AttendanceListGeneralMeeting::where('general_meeting_id', $request->general_meeting_id)->get();
        return api_response(true, "Liste de présence", $attendance_list_general_meeting , 200);
    }

    public function generatePdf(ListAttendanceListGeneralMeetingRequest $request) {
        try {

            $general_meeting = GeneralMeeting::find($request['general_meeting_id']);
            $data = $this->attendance->generatePdf($general_meeting);
            return $data;
        } catch (\Throwable $th) {
            return api_error($success = false, 'Une erreur s\'est produite lors de l\'opération', ['server' => $th->getMessage()]);
        }
    }

    /**
     * Add a newly created resource in storage.
     */
    public function add(AddAttendanceListGeneralMeetingRequest $request)
    {
        try {
            $this->attendance->add($request->all());
            return api_response(true, "Succès de l'enregistrement de la liste de présence", '', 200);
        }catch (ValidationException $e) {
                return api_response(false, "Echec de l'enregistrement de la liste de présence", $e->errors(), 422);
        }
    }

    /**
     * Delete the specified resource in storage.
     */
    public function delete(DeleteAttendanceListGeneralMeetingRequest $request)
    {
        try {

            $this->attendance->delete($request->all());
            return api_response(true, "Liste de présence mis à jour avec succès", '', 200);
        } catch (ValidationException $e) {

            return api_response(false, "Echec de la mise à jour de la liste de présence", $e->errors(), 422);
        }
    }
}
