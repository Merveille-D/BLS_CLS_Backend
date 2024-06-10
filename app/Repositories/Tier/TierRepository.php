<?php
namespace App\Repositories\Tier;

use App\Models\Gourvernance\Tier;
use Illuminate\Support\Facades\Auth;

class TierRepository
{
    public function __construct(private Tier $tier) {

    }

    /**
     * @param Request $request
     *
     * @return Tier
     */
    public function store($request) {

        $request['created_by'] = Auth::user()->id;
        $tier = $this->tier->create($request);
        return $tier;
    }

    /**
     * @param Request $request
     *
     * @return Tier
     */
    public function update(Tier $tier, $request) {

        $tier->update($request);
        return $tier;
    }


}
