<?php
namespace App\Repositories\ManagementCommittee;

use App\Models\Gourvernance\ExecutiveManagement\Directors\Director;

class DirectorRepository
{
    public function __construct(private Director $director) {

    }

    /**
     * @param Request $request
     *
     * @return Director
     */
    public function add($request) {

        $director = $this->director->create($request->all());
        return $director;
    }

    /**
     * @param Request $request
     *
     * @return Director
     */
    public function update(Director $director, $request) {

        $director->update($request);
        return $director;
    }

}
