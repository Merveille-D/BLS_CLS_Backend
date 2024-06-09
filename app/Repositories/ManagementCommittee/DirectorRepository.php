<?php
namespace App\Repositories\ManagementCommittee;

use App\Models\Gourvernance\ExecutiveManagement\Directors\Director;
use App\Models\Gourvernance\Mandate;
use Carbon\Carbon;

class DirectorRepository
{
    public function __construct(private Director $director) {

    }

    /**
     * @param Request $request
     *
     * @return Director
     */
    public function add($request) {

        $director = $this->director->create($request->all());

        $director->mandates()->create([
            'appointment_date' => $request['appointment_date'],
            'expiry_date' => Carbon::parse($request['appointment_date'])->addYears(5),
            'renewal_date' => Carbon::parse($request['appointment_date'])->addYears(5)->addDay(1),
        ]);

        return $director;
    }

    /**
     * @param Request $request
     *
     * @return Director
     */
    public function update(Director $director, $request) {

        $director->update($request);
        return $director;
    }

    public function renewMandate($request) {

        $director = Director::find($request['director_id']);

        $director->mandates()->create([
            'appointment_date' => $request['appointment_date'],
            'expiry_date' => Carbon::parse($request['appointment_date'])->addYears(5),
            'renewal_date' => Carbon::parse($request['appointment_date'])->addYears(5)->addDay(1),
        ]);

        return $director;
    }

}
