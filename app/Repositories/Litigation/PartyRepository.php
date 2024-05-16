<?php

namespace App\Repositories\Litigation;

use App\Http\Resources\Litigation\PartyResource;
use App\Models\Litigation\LitigationParty;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * PartyRepository
 */
class PartyRepository
{

    public function __construct(private LitigationParty $party_model)
    {
    }

    public function getList($request) : ResourceCollection {
        $search = $request->search;
        $query = $this->party_model
                ->when(!blank($search), function($qry) use($search) {
                    $qry->where('name', 'like', '%'.$search.'%');
                })
                ->paginate();


        return PartyResource::collection($query);
    }

    public function add($request) : JsonResource
    {
        $party = $this->party_model->create([
            'name' => $request->name,
            // 'category' => $request->category,
            'type' => $request->type,
            'phone' => $request->phone,
            'email' => $request->email,
        ]);

        return new PartyResource($party);
    }
}
