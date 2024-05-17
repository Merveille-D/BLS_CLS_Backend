<?php
namespace App\Repositories\Evaluation;

use App\Concerns\Traits\Transfer\AddTransferTrait;
use App\Models\Evaluation\Notation;

class NotationRepository
{
    use AddTransferTrait;

    public function __construct(private Notation $notation) {

    }

    /**
     * @param Request $request
     *
     * @return Notation
     */
    public function store($request) {

        $check_collaborator_notation = $this->notation->where('collaborator_id', $request['collaborator_id'])->first();

        $notes = $request['notes'];
        $sum = 0;

        foreach ($notes as $note) {
            $sum += $note['note'];
        }
        $request['note'] = $sum;

        if($check_collaborator_notation) {

            $check_collaborator_notation->update($request->all());

            foreach ($notes as $note) {
                $check_collaborator_notation->performances()->update([
                    'performance_indicator_id' => $note['performance_indicator_id'],
                    'note' => $note['note']
                ]);
            }

            return $check_collaborator_notation;
        }else {

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

    public function createTransfer(Notation $notation, $request) {

        $this->add_transfer($notation, $request['forward_title'], $request['deadline_transfer'], $request['description'], $request['collaborators']);

        return $notation;
    }


}
