<?php
namespace App\Repositories\Evaluation;

use App\Models\Evaluation\Position;

class PositionRepository
{
    public function __construct(private Position $position) {

    }

    /**
     * @param Request $request
     *
     * @return Position
     */
    public function store($request) {

        $position = $this->position->create($request);
        return $position;
    }

    /**
     * @param Request $request
     *
     * @return Position
     */
    public function update(Position $position, $request) {

        $position->update($request);
        return $position;
    }


}
