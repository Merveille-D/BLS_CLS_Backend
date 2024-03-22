<?php
namespace App\Repositories;

use App\Enums\AdminFunction;
use App\Enums\AdminType;
use App\Enums\Quality;
use App\Models\Gourvernance\BoardDirectors\Administrators\CaAdministrator;

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
            $admin = $this->admin->create($request->all());

            return $admin;
        } else if ($request->type == AdminType::CORPORATE) {
            $company_info = [
                'name' => $request->denomination,
                'address' => $request->company_head_office,
                'nationality' => $request->company_nationality,
                'type' => $request->type
            ];
            $representant = $this->admin->create($request->except('denomination', 'company_head_office', 'company_nationality', 'type'));

            $corporate = $this->admin->create(array_merge(['permanent_representative_id' => $representant->id], $company_info));
            return $corporate;
        }
    }

    public function settings() : array {
        return array(
            'quality' => Quality::QUALITIES_VALUES,
            'type' => AdminType::TYPES_VALUES,
            'function' => AdminFunction::ADMIN_FUNCTIONS_VALUES,
        );
    }
}
