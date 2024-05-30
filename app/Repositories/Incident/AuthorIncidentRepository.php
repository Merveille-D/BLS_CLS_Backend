<?php
namespace App\Repositories\Incident;

use App\Models\Gourvernance\GourvernanceDocument;
use App\Models\Incident\AuthorIncident;
use Illuminate\Support\Facades\Auth;

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

        $request['created_by'] = Auth::user()->id;
        $authorIncident = $this->authorIncident->create($request);
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
