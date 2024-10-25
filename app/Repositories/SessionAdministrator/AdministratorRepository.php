<?php

namespace App\Repositories\SessionAdministrator;

use App\Enums\AdminFunction;
use App\Enums\AdminType;
use App\Enums\Quality;
use App\Models\Gourvernance\BoardDirectors\Administrators\CaAdministrator;
use App\Models\Gourvernance\ExecutiveCommittee;
use Carbon\Carbon;

class AdministratorRepository
{
    public function __construct(private CaAdministrator $admin) {}

    /**
     * @param  Request  $request
     * @return CaAdministrator
     */
    public function add($request)
    {
        if ($request->type == AdminType::INDIVIDUAL) {
            $administrator = $this->admin->create($request->all());

        } elseif ($request->type == AdminType::CORPORATE) {
            $company_info = [
                'name' => $request->denomination,
                'address' => $request->company_head_office,
                'nationality' => $request->company_nationality,
                'type' => $request->type,
            ];
            $representant = $this->admin->create($request->except('denomination', 'company_head_office', 'company_nationality', 'type'));

            $administrator = $this->admin->create(array_merge(['permanent_representative_id' => $representant->id], $company_info));

        }

        $administrator->mandates()->create([
            'appointment_date' => $request['appointment_date'],
            'expiry_date' => Carbon::parse($request['appointment_date'])->addYears(5),
            'renewal_date' => Carbon::parse($request['appointment_date'])->addYears(5)->addDay(1),
        ]);

        return $administrator;

    }

    /**
     * @param  Request  $request
     * @return CaAdministrator
     */
    public function update(CaAdministrator $administrator, $request)
    {

        if ($request['type'] == AdminType::INDIVIDUAL) {
            $administrator->update($request);

        } elseif ($request['type'] == AdminType::CORPORATE) {
            $company_info = [
                'name' => $request->denomination,
                'address' => $request->company_head_office,
                'nationality' => $request->company_nationality,
                'type' => $request->type,
            ];
            $administrator->update($request->except('denomination', 'company_head_office', 'company_nationality', 'type'));

            $corporate = CaAdministrator::where('permanent_representative_id', $administrator->id)->first();
            $corporate->update(array_merge(['permanent_representative_id' => $administrator->id], $company_info));

        }

        return $administrator;
    }

    public function settings(): array
    {
        return [
            'quality' => Quality::QUALITIES_VALUES,
            'type' => AdminType::TYPES_VALUES,
            'function' => AdminFunction::ADMIN_FUNCTIONS_VALUES,
        ];
    }

    public function toggle($ca_administrator, $request)
    {
        $existingRecord = ExecutiveCommittee::where('committee_id', $request['committee_id'])
            ->where('committable_id', $ca_administrator->id)
            ->first();

        if ($existingRecord) {
            $existingRecord->delete();
        } else {

            $executive_committee = new ExecutiveCommittee;
            $executive_committee->committee_id = $request['committee_id'];
            $ca_administrator->executiveCommittees()->save($executive_committee);
        }
    }

    public function renewMandate($request)
    {

        $administrator = CaAdministrator::find($request['administrator_id']);

        $administrator->mandates()->create([
            'appointment_date' => $request['appointment_date'],
            'expiry_date' => Carbon::parse($request['appointment_date'])->addYears(5),
            'renewal_date' => Carbon::parse($request['appointment_date'])->addYears(5)->addDay(1),
        ]);

        return $administrator;
    }
}
