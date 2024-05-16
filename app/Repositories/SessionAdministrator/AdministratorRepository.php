<?php
namespace App\Repositories\SessionAdministrator;

use App\Enums\AdminFunction;
use App\Enums\AdminType;
use App\Enums\Quality;
use App\Models\Gourvernance\BoardDirectors\Administrators\CaAdministrator;
use App\Models\Gourvernance\Mandate;

class AdministratorRepository
{
    public function __construct(private CaAdministrator $admin) {

    }


    /**
     * @param Request $request
     *
     * @return CaAdministrator
     */
    public function add($request) {
        if ($request->type == AdminType::INDIVIDUAL) {
            $administrator = $this->admin->create($request->all());

        } else if ($request->type == AdminType::CORPORATE) {
            $company_info = [
                'name' => $request->denomination,
                'address' => $request->company_head_office,
                'nationality' => $request->company_nationality,
                'type' => $request->type
            ];
            $representant = $this->admin->create($request->except('denomination', 'company_head_office', 'company_nationality', 'type'));

            $administrator = $this->admin->create(array_merge(['permanent_representative_id' => $representant->id], $company_info));

        }

        $administrator->mandates()->create([
            'appointment_date' => $request['appointment_date'] ?? null,
            'renewal_date' => $request['renewal_date'] ?? null,
            'expiry_date' => $request['expiry_date'] ?? null,
        ]);

        return $administrator;

    }

    /**
     * @param Request $request
     *
     * @return CaAdministrator
     */
    public function update(CaAdministrator $administrator, $request) {

        if ($request->type == AdminType::INDIVIDUAL) {
            $administrator->update($request->all());

        } else if ($request->type == AdminType::CORPORATE) {
            $company_info = [
                'name' => $request->denomination,
                'address' => $request->company_head_office,
                'nationality' => $request->company_nationality,
                'type' => $request->type
            ];
            $administrator->update($request->except('denomination', 'company_head_office', 'company_nationality', 'type'));

            $corporate = CaAdministrator::where('permanent_representative_id', $administrator->id)->first();
            $corporate->update(array_merge(['permanent_representative_id' => $administrator->id], $company_info));

        }


        $mandates = $administrator->mandates()->where('status', 'active')->exists();

        if (!$mandates) {

            $administrator->mandates()->create([
                'appointment_date' => $request['appointment_date'] ?? null,
                'renewal_date' => $request['renewal_date'] ?? null,
                'expiry_date' => $request['expiry_date'] ?? null,
            ]);
        }else {
            $last_mandate = $administrator->mandates()->where('status', 'active')->latest()->first();
            $administrator->mandates()->update([
                'appointment_date' => $request['appointment_date'] ?? null,
                'renewal_date' => $request['renewal_date'] ?? null,
                'expiry_date' => $request['expiry_date'] ?? null,
                'status' => ($last_mandate->expiry_date < now()) ? 'expired' : 'active',
            ]);
        }

        return $administrator;
    }

    public function settings() : array {
        return array(
            'quality' => Quality::QUALITIES_VALUES,
            'type' => AdminType::TYPES_VALUES,
            'function' => AdminFunction::ADMIN_FUNCTIONS_VALUES,
        );
    }
}
