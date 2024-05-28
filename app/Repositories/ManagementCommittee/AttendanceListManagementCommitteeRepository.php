<?php
namespace App\Repositories\ManagementCommittee;

use App\Concerns\Traits\PDF\GeneratePdfTrait;
use App\Models\Gourvernance\ExecutiveManagement\Directors\Director;
use App\Models\Gourvernance\ExecutiveManagement\ManagementCommittee\AttendanceListManagementCommittee;
use App\Models\Gourvernance\Representant;

class AttendanceListManagementCommitteeRepository
{
    use GeneratePdfTrait;

    public function __construct(private AttendanceListManagementCommittee $attendance) {

    }

    /**
     * @param Request $request
     *
     * @return AttendanceListManagementCommittee
     */
    public function list($request) {

        $directors = Director::select('name', 'id')->get()->map(function ($director) {
            $director->type = "director";
            $director->status = (empty(AttendanceListManagementCommittee::where('director_id', $director->id)->get())) ? true : false ;
            return $director;
        });
        $representants = Representant::select('grade', 'name', 'id')->get()->map(function ($representant) {
            $representant->type = "not_director";
            $representant->status = (AttendanceListManagementCommittee::where('representant_id', $representant->id)->get()) ? true : false ;
            return $representant;
        });

        $directors = $directors->merge($representants);

        return $directors;
    }

    /**
     * @param Request $request
     * @param AttendanceListManagementCommittee $attendanceListManagementCommittee
     *
     * @return AttendanceListManagementCommittee
     */
    public function update($request) {

        foreach ($request['directors'] as $director) {

            if ($director['status']) {
                $data = [
                    'session_id' => $request['management_committee_id']
                ];

                if ($director['type'] == 'director') {
                    $data['director_id'] = $director['id'];
                } else {
                    $data['representant_id'] = $director['id'];
                }
                $this->attendance->create($data);
            }else {
                $this->attendance->where('session_id', $request['management_committee_id'])
                                ->where($director['type'] == 'director' ? 'director_id' : 'representant_id', $director['id'])
                                ->delete();
            }
        }
        return 0;
    }

    public function generatePdf($management_committee){

        $directors_id = $management_committee->attendanceList()->pluck('director_id');
        $directors = Director::whereIn('id', $directors_id)->get();

        $representants_id = $management_committee->attendanceList()->pluck('representant_id');
        $representants = Representant::whereIn('id', $representants_id)->get();

        $directors = $directors->merge($representants);

        $pdf =  $this->generateFromView( 'pdf.management_committee.attendance',  [
            'directors' => $directors,
            'management_committee' => $management_committee,
        ]);
        return $pdf;
    }
}
