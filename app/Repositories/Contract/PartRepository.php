<?php

namespace App\Repositories\Contract;

use App\Models\Contract\Part;
use Illuminate\Support\Facades\Auth;

class PartRepository
{
    public function __construct(private Part $part) {}

    /**
     * @param  Request  $request
     * @return Part
     */
    public function store($request)
    {
        $request['created_by'] = Auth::user()->id;

        if ($request->type == 'individual') {
            $part = $this->part->create($request);

            return $part;
        } elseif ($request->type == 'corporate') {
            $company_info = [
                'name' => $request->denomination,
                'number_rccm' => $request->number_rccm,
                'number_ifu' => $request->number_ifu,
                'id_card' => $request->id_card,
                'capital' => $request->capital,
                'type' => 'corporate',
            ];

            $request->merge(['type' => 'individual']);
            $representant = $this->part->create($request->except('denomination', 'number_rccm', 'number_ifu', 'capital'));

            $corporate = $this->part->create(array_merge(['permanent_representative_id' => $representant->id], $company_info));

            return $corporate;
        }
    }
}
