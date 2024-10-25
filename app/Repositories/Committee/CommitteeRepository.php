<?php

namespace App\Repositories\Committee;

use App\Models\Gourvernance\Committee;

class CommitteeRepository
{
    public function __construct(private Committee $committee) {}

    /**
     * @param  Request  $request
     * @return Committee
     */
    public function list($request)
    {

        $committees = Committee::where('type', $request['type'])->get();

        return $committees;
    }

    /**
     * @param  Request  $request
     * @return Committee
     */
    public function store($request)
    {

        $committee = $this->committee->create($request);

        return $committee;
    }

    /**
     * @param  Request  $request
     * @return Committee
     */
    public function update(Committee $committee, $request)
    {
        $committee->update($request);

        return $committee;
    }

    /**
     * @param  Request  $request
     * @return Committee
     */
    public function listExecutives($committee)
    {

        $executive_committees = $committee->executiveCommittees()->with('committable')->get();

        return $executive_committees;
    }
}
