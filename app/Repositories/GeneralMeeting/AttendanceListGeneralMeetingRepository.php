<?php
namespace App\Repositories\GeneralMeeting;

use App\Concerns\Traits\PDF\GeneratePdfTrait;
use App\Models\Gourvernance\GeneralMeeting\AttendanceListGeneralMeeting;
use App\Models\Shareholder\Shareholder;

class AttendanceListGeneralMeetingRepository
{
    use GeneratePdfTrait;

    public function __construct(private AttendanceListGeneralMeeting $attendance) {

    }

    /**
     * @param Request $request
     *
     * @return AttendanceListGeneralMeeting
     */
    public function add($request) {

        foreach($request['shareholders'] as $shareholder_id) {
            $this->attendance->create([
                'general_meeting_id' => $request['general_meeting_id'],
                'shareholder_id' => $shareholder_id,
            ]);
        }
        return 0;
    }

    /**
     * @param Request $request
     * @param AttendanceListGeneralMeeting $attendanceListGeneralMeeting
     *
     * @return AttendanceListGeneralMeeting
     */
    public function delete($request) {

        foreach( $request['shareholders'] as $shareholder_id) {
            $attendance = $this->attendance
                                ->where('general_meeting_id', $request['general_meeting_id'])
                                ->where('shareholder_id', $shareholder_id)
                                ->get();
            $attendance->delete();
        }
        return 0;
    }

    public function generatePdf($general_meeting){

        $shareholders_id = $general_meeting->attendanceList()->pluck('shareholder_id');
        $shareholders = Shareholder::whereIn('id', $shareholders_id);

        $pdf =  $this->generateFromView( 'pdf.general_meeting.attendance',  ['shareholders' => $shareholders]);
        return $pdf;
    }
}
