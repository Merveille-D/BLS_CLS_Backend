<?php
namespace App\Repositories;

use App\Models\Gourvernance\BoardDirectors\Sessions\SessionAdministrator;
use App\Models\Gourvernance\GeneralMeeting\AttendanceListGeneralMeeting;
use App\Models\Gourvernance\GourvernanceDocument;

class AttendanceListGeneralMeetingRepository
{
    public function __construct(private AttendanceListGeneralMeeting $attendance) {

    }

    /**
     * @param Request $request
     *
     * @return AttendanceListGeneralMeeting
     */
    public function store($request) {
        $attendanceListGeneralMeeting = $this->attendance->create($request->all());
        return $attendanceListGeneralMeeting;
    }

    /**
     * @param Request $request
     * @param AttendanceListGeneralMeeting $attendanceListGeneralMeeting
     *
     * @return AttendanceListGeneralMeeting
     */
    public function update($attendanceListGeneralMeeting, $request) {
        $attendanceListGeneralMeeting->update($request);
        return $attendanceListGeneralMeeting;
    }
}
