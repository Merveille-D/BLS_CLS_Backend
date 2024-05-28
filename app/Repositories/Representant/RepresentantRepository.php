<?php
namespace App\Repositories\Representant;

use App\Models\Gourvernance\GourvernanceDocument;
use App\Models\Gourvernance\Representant;

class RepresentantRepository
{
    public function __construct(private Representant $representant) {

    }

    /**
     * @param Request $request
     *
     * @return Representant
     */
    public function store($request) {

        $representant = $this->representant->create($request);

        $request['representant_id'] = $representant->id;
        $request[Representant::MEETING_TYPE_ID[$request['type']]] = $request['meeting_id'];
        $model = Representant::MEETING_MODEL[$request['type']];
        $model::create($request);

        return $representant;
    }

    /**
     * @param Request $request
     *
     * @return Representant
     */
    public function update(Representant $representant, $request) {

        $representant->update($request);
        return $representant;
    }


}
