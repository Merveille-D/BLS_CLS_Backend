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

        $director->mandates()->create([
            'appointment_date' => $request['appointment_date'] ?? null,
            'renewal_date' => $request['renewal_date'] ?? null,
            'expiry_date' => $request['expiry_date'] ?? null,
        ]);

        return $director;
    }

    /**
     * @param Request $request
     *
     * @return Director
     */
    public function update(Director $director, $request) {

        $mandates = $director->mandates()->where('status', 'active')->exists();

        if (!$mandates) {

            $director->mandates()->create([
                'appointment_date' => $request['appointment_date'] ?? null,
                'renewal_date' => $request['renewal_date'] ?? null,
                'expiry_date' => $request['expiry_date'] ?? null,
            ]);
        }else {
            $last_mandate = $director->mandates()->where('status', 'active')->latest()->first();
            $director->mandates()->update([
                'appointment_date' => $request['appointment_date'] ?? null,
                'renewal_date' => $request['renewal_date'] ?? null,
                'expiry_date' => $request['expiry_date'] ?? null,
                'status' => ($last_mandate->expiry_date < now()) ? 'expired' : 'active',
            ]);
        }

        $director->update($request);

        return $director;
    }

}
