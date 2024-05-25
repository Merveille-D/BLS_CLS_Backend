<?php
namespace App\Repositories\SessionAdministrator;

use App\Concerns\Traits\PDF\GeneratePdfTrait;
use App\Models\Gourvernance\BoardDirectors\Administrators\CaAdministrator;
use App\Models\Gourvernance\BoardDirectors\Sessions\AttendanceListSessionAdministrator;
use App\Models\Gourvernance\BoardDirectors\Sessions\SessionAdministrator;

class AttendanceListSessionAdministratorRepository
{
    use GeneratePdfTrait;

    public function __construct(private AttendanceListSessionAdministrator $attendance) {

    }

    /**
     * @param Request $request
     *
     * @return AttendanceListSessionAdministrator
     */
    public function add($request) {

        foreach($request['administrators'] as $administrator_id) {
            $this->attendance->create([
                'session_id' => $request['session_id'],
                'administrator_id' => $administrator_id,
            ]);
        }
        return 0;
    }

    /**
     * @param Request $request
     * @param AttendanceListSessionAdministrator $attendanceListSessionAdministrator
     *
     * @return AttendanceListSessionAdministrator
     */
    public function delete($request) {

        foreach( $request['administrators'] as $administrator_id) {
            $attendance = $this->attendance
                                ->where('session_id', $request['session_id'])
                                ->where('administrator_id', $administrator_id)
                                ->get();
            $attendance->delete();
        }
        return 0;
    }

    public function generatePdf($session_administrator){

        $meeting_type = SessionAdministrator::SESSION_MEETING_TYPES_VALUES[$session_administrator->type];

        $administrators_id = $session_administrator->attendanceList()->pluck('administrator_id');
        $administrators = CaAdministrator::whereIn('id', $administrators_id)->get();

        $pdf =  $this->generateFromView( 'pdf.session_administrator.attendance',  [
            'administrators' => $administrators,
            'session_administrator' => $session_administrator,
            'meeting_type' => $meeting_type,
        ]);
        return $pdf;
    }
}
