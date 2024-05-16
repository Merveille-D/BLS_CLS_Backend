<?php
namespace App\Repositories\Evaluation;

use App\Models\Evaluation\Collaborator;
use DateTime;

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

        $collaborator = $this->collaborator->create($request->all());
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
