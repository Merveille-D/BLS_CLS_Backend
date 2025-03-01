<?php

namespace App\Http\Controllers\API\V1\Gourvernance\GeneralMeeting;

use App\Http\Controllers\Controller;
use App\Http\Requests\AttendanceListGeneralMeeting\UpdateAttendanceListGeneralMeetingRequest;
use App\Http\Requests\GeneralMeeting\GeneratePdfGeneralMeetingRequest;
use App\Models\Gourvernance\GeneralMeeting\GeneralMeeting;
use App\Repositories\GeneralMeeting\AttendanceListGeneralMeetingRepository;
use Illuminate\Validation\ValidationException;
use Throwable;

class AttendanceListGeneralMeetingController extends Controller
{
    public function __construct(private AttendanceListGeneralMeetingRepository $attendance) {}

    /**
     * Display a listing of the resource.
     */
    public function list(GeneratePdfGeneralMeetingRequest $request)
    {
        $attendance_list_general_meeting = $this->attendance->list($request->all());

        return api_response(true, 'Liste de présence', $attendance_list_general_meeting, 200);
    }

    /**
     * Add a newly created resource in storage.
     */
    public function updateStatus(UpdateAttendanceListGeneralMeetingRequest $request)
    {
        try {
            $this->attendance->update($request->all());

            return api_response(true, 'Succès de la mise à jour de la liste de présence', '', 200);
        } catch (ValidationException $e) {
            return api_response(false, "Echec de l'enregistrement de la liste de présence", $e->errors(), 422);
        }
    }

    public function generatePdf(GeneratePdfGeneralMeetingRequest $request)
    {
        try {

            $general_meeting = GeneralMeeting::find($request['general_meeting_id']);
            $data = $this->attendance->generatePdf($general_meeting);

            return $data;
        } catch (Throwable $th) {
            return api_error($success = false, 'Une erreur s\'est produite lors de l\'opération', ['server' => $th->getMessage()]);
        }
    }
}
