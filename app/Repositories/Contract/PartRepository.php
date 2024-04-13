<?php
namespace App\Repositories\Contract;

use App\Enums\AdminType;
use App\Models\Contract\Part;

class PartRepository
{
    public function __construct(private Part $part) {

    }


    /**
     * @param Request $request
     *
     * @return Part
     */
    public function store($request) {
        if ($request->type == "individual") {
            $part = $this->part->create($request->all());

            return $part;
        } else if ($request->type == "corporate") {
            $company_info = [
                'name' => $request->denomination,
                'number_rccm' => $request->number_rccm,
                'number_ifu' => $request->number_ifu,
                'id_card' => $request->id_card,
                'capital' => $request->capital,
                'type' => 'corporate'
            ];

            $request->merge(['type' => 'individual']);
            $representant = $this->part->create($request->except('denomination', 'number_rccm', 'number_ifu', 'id_card', 'capital'));

            $corporate = $this->part->create(array_merge(['permanent_representative_id' => $representant->id], $company_info));
            return $corporate;
        }
    }

}
