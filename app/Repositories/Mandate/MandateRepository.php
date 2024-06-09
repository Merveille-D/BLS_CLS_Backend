<?php
namespace App\Repositories\Mandate;

use App\Models\Gourvernance\Mandate;
use Carbon\Carbon;

class MandateRepository
{
    public function __construct(private Mandate $mandate) {

    }

    /**
     * @param Request $request
     *
     * @return Mandate
     */
    public function update(Mandate $mandate, $request) {

        if($request['type'] == 'update') {

            $mandate->update([
                'appointment_date' => $request['appointment_date'],
                'expiry_date' => Carbon::parse($request['appointment_date'])->addYears(5),
                'renewal_date' => Carbon::parse($request['appointment_date'])->addYears(5)->addDay(1),
            ]);
        } else {

            $mandate->mandatable->mandates()->create([
                'appointment_date' => $request['renew_appointment_date'],
                'expiry_date' => Carbon::parse($request['renew_appointment_date'])->addYears(5),
                'renewal_date' => Carbon::parse($request['renew_appointment_date'])->addYears(5)->addDay(1),
            ]);
        }

        return $mandate;
    }


}
