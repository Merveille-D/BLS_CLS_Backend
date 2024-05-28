<?php
namespace App\Repositories\GeneralMeeting;

use App\Concerns\Traits\PDF\GeneratePdfTrait;
use App\Models\Gourvernance\GeneralMeeting\AttendanceListGeneralMeeting;
use App\Models\Gourvernance\GeneralMeeting\GeneralMeeting;
use App\Models\Gourvernance\Representant;
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
    public function list() {

        $shareholders = Shareholder::select('name', 'id')->get()->map(function ($shareholder) {
            $shareholder->type = "shareholder";
            $shareholder->status = (AttendanceListGeneralMeeting::where('general_meeting_id', request('general_meeting_id'))->where('shareholder_id', $shareholder->id)->exists()) ? true : false ;
            return $shareholder;
        });

        $representants = Representant::select('grade', 'name', 'id')->get()->map(function ($representant) {
            $representant->type = "not_shareholder";
            $representant->status = (AttendanceListGeneralMeeting::where('general_meeting_id',  request('general_meeting_id'))->where('representant_id', $representant->id)->exists()) ? true : false ;
            return $representant;
        });

        $shareholders = $shareholders->merge($representants);

        return $shareholders;
    }

    /**
     * @param Request $request
     *
     * @return AttendanceListGeneralMeeting
     */
    public function update($request) {

        foreach ($request['shareholders'] as $shareholder) {

            if ($shareholder['status']) {
                $data = [
                    'general_meeting_id' => $request['general_meeting_id']
                ];

                if ($shareholder['type'] == 'shareholder') {
                    $data['shareholder_id'] = $shareholder['id'];
                } else {
                    $data['representant_id'] = $shareholder['id'];
                }
                $this->attendance->create($data);
            }else {
                $this->attendance ->where('general_meeting_id', $request['general_meeting_id'])
                                ->where($shareholder['type'] == 'shareholder' ? 'shareholder_id' : 'representant_id', $shareholder['id'])
                                ->delete();
            }
        }
        return 0;
    }

    public function generatePdf($general_meeting){

        $meeting_type = GeneralMeeting::GENERAL_MEETING_TYPES_VALUE[$general_meeting->type];

        $shareholders_id = $general_meeting->attendanceList()->pluck('shareholder_id');
        $shareholders = Shareholder::whereIn('id', $shareholders_id)->get();

        $representants_id = $general_meeting->attendanceList()->pluck('representant_id');
        $representants = Representant::whereIn('id', $representants_id)->get();

        $shareholders = $shareholders->merge($representants);

        $pdf =  $this->generateFromView( 'pdf.general_meeting.attendance',  [
            'shareholders' => $shareholders,
            'general_meeting' => $general_meeting,
            'meeting_type' => $meeting_type,
        ]);
        return $pdf;
    }
}
