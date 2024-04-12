<?php
namespace App\Repositories\Incident;

use App\Models\Gourvernance\GourvernanceDocument;
use App\Models\Incident\AuthorIncident;

class AuthorIncidentRepository
{
    public function __construct(private AuthorIncident $authorIncident) {

    }

    /**
     * @param Request $request
     *
     * @return AuthorIncident
     */
    public function store($request) {

        $authorIncident = $this->authorIncident->create($request->all());
        return $authorIncident;
    }

     /**
     * @param Request $request
     *
     * @return AuthorIncident
     */
    public function update(AuthorIncident $authorIncident, $request) {

        $authorIncident->update($request);
        return $authorIncident;
    }


}
