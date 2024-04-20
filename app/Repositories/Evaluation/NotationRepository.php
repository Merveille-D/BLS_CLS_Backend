<?php
namespace App\Repositories\Evaluation;

use App\Models\Bank\Bank;
use App\Models\Evaluation\Notation;
use App\Models\Gourvernance\GourvernanceDocument;
use DateTime;

class NotationRepository
{
    public function __construct(private Notation $notation) {

    }

    /**
     * @param Request $request
     *
     * @return Notation
     */
    public function store($request) {

        $check_collaborator_notation = $this->notation->where('collaborator_id', $request['collaborator_id'])->first();

        if($check_collaborator_notation) {
            $check_collaborator_notation->update($request->all());

            $notes = $request['notes'];

            foreach ($notes as $note) {
                $check_collaborator_notation->performances()->update([
                    'performance_indicator_id' => $note['performance_indicator_id'],
                    'note' => $note['note']
                ]);
            }

            return $check_collaborator_notation;
        }else {
            $notation = $this->notation->create($request->all());

            $notes = $request['notes'];

            foreach ($notes as $note) {
                $notation->performances()->create([
                    'performance_indicator_id' => $note['performance_indicator_id'],
                    'note' => $note['note']
                ]);
            }

            return $notation;
        }
    }

    /**
     * @param Request $request
     *
     * @return Notation
     */
    public function update(Notation $notation, $request) {

       //
    }


}
