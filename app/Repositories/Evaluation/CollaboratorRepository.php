<?php
namespace App\Repositories\Evaluation;

use App\Models\Evaluation\Collaborator;
use DateTime;
use Illuminate\Support\Facades\Auth;

class CollaboratorRepository
{
    public function __construct(private Collaborator $collaborator) {

    }

    /**
     * @param Request $request
     *
     * @return Collaborator
     */
    public function store($request) {

        $request['created_by'] = Auth::user()->id;
        $collaborator = $this->collaborator->create($request);
        return $collaborator;
    }

    /**
     * @param Request $request
     *
     * @return Collaborator
     */
    public function update(Collaborator $collaborator, $request) {

        $collaborator->update($request);
        return $collaborator;
    }

}
