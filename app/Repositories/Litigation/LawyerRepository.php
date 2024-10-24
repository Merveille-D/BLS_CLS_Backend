<?php

namespace App\Repositories\Litigation;

use App\Http\Resources\Litigation\LawyerResource;
use App\Models\Litigation\LitigationLawyer;

class LawyerRepository
{
    public function __construct(private LitigationLawyer $litigation_lawyer) {}

    public function getList($request)
    {
        $search = $request->search;
        $query = $this->litigation_lawyer
            ->when(! blank($search), function ($qry) use ($search) {
                $qry->where('name', 'like', '%' . $search . '%');
            })
            ->paginate();

        return LawyerResource::collection($query);
    }
}
