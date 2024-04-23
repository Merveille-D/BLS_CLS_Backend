<?php
namespace App\Repositories\ManagementCommittee;

use App\Models\Gourvernance\ExecutiveManagement\Directors\Director;
use App\Models\Gourvernance\Mandate;

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
        return $director;
    }

    /**
     * @param Request $request
     *
     * @return Director
     */
    public function update(Director $director, $request) {

        $first_mandat = $director->mandates()->first();

        if($first_mandat->expiry_date < now()) {
            $mandat = new Mandate();

            $mandat->appointment_date = $request['appointment_date'] ?? null;
            $mandat->renewal_date = $request['renewal_date'] ?? null;
            $mandat->expiry_date = $request['expiry_date'] ?? null;

            $director->mandates()->save($mandat);
        }

        $director->update($request);

        return $director;
    }

}
