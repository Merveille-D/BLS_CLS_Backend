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

            $notes = $request['notes'];
            $sum = 0;

            foreach ($notes as $note) {
                $sum += $note['note'];
            }

            $request['note'] = $sum;
            $check_collaborator_notation->update($request->all());

            foreach ($notes as $note) {
                $check_collaborator_notation->performances()->update([
                    'performance_indicator_id' => $note['performance_indicator_id'],
                    'note' => $note['note']
                ]);
            }

            return $check_collaborator_notation;
        }else {

            $notes = $request['notes'];
            $sum = 0;

            foreach ($notes as $note) {
                $sum += $note['note'];
            }
            $request['note'] = $sum;

            $notation = $this->notation->create($request->all());

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
