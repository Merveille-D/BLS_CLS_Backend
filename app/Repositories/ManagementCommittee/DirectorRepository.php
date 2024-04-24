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

        if (!isset($first_mandat) || $first_mandat->expiry_date < now()) {

            $director->mandates()->create([
                'appointment_date' => $request['appointment_date'] ?? null,
                'renewal_date' => $request['renewal_date'] ?? null,
                'expiry_date' => $request['expiry_date'] ?? null,
            ]);
        }else {
            $director->mandates()->update([
                'appointment_date' => $request['appointment_date'] ?? null,
                'renewal_date' => $request['renewal_date'] ?? null,
                'expiry_date' => $request['expiry_date'] ?? null,
            ]);
        }

        $director->update($request);

        return $director;
    }

}
