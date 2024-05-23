<?php
namespace App\Repositories\Evaluation;

use App\Concerns\Traits\Transfer\AddTransferTrait;
use App\Models\Evaluation\Notation;
use Illuminate\Support\Facades\Auth;

class NotationRepository
{
    use AddTransferTrait;

    public function __construct(private Notation $notation) {

    }

    public function all() {
        return $this->notation->whereNull('parent_id')->get()->makeHidden('performances')->map(function ($notation) {
            $notation->indicators = $notation->indicators;
            $notation->collaborator = $notation->collaborator;

            $notation->steps = $notation->steps->map(function ($step) {
                $step->indicators = $step->indicators;
                return $step;
            });

            return $notation;
        });
    }

    /**
     * @param Request $request
     *
     * @return Notation
     */
    public function store($request) {

        $request = $request->all();

        $check_collaborator_notation = $this->notation->where('collaborator_id', $request['collaborator_id'])->first();

        $notes = $request['notes'];
        $sum = 0;
        foreach ($notes as $note) {
            $sum += $note['note'];
        }
        $request['note'] = $sum;

        if($check_collaborator_notation) {

            $transfers = $check_collaborator_notation->transfers;

            if($transfers->count() == 0) {

                $this->updateEvaluation($check_collaborator_notation, $request, $notes);
            }else {

                $created_by_last_transfer = $transfers->last()->collaborators->first()->id;

                if($created_by_last_transfer == Auth::user()->id) {

                    if($transfers->last()->status == true) {
                        $request['created_by'] = Auth::user()->id;
                        $request['parent_id'] = $check_collaborator_notation->id;
                        $request['status'] = $transfers->last()->title;

                        $this->createEvaluation($request, $notes);
                    }else {
                        $collaborator_notation = $check_collaborator_notation->where('created_by', Auth::user()->id)->first();

                        if($collaborator_notation) {
                            $this->updateEvaluation($collaborator_notation, $request, $notes);
                        }

                    }
                }
            }

        }else {

            $request['created_by'] = Auth::user()->id;
            $check_collaborator_notation = $this->createEvaluation($request, $notes);

        }

        return $check_collaborator_notation;
    }

    public function createEvaluation($request, $notes) {


        $notation = $this->notation->create($request);

        foreach ($notes as $note) {
            $notation->performances()->create([
                'performance_indicator_id' => $note['audit_performance_indicator_id'],
                'note' => $note['note']
            ]);
        }

        return $notation;
    }

    public function updateEvaluation($check_collaborator_notation, $request, $notes) {

        $check_collaborator_notation->update($request);

        foreach ($notes as $note) {
            $check_collaborator_notation->performances()->update([
                'performance_indicator_id' => $note['audit_performance_indicator_id'],
                'note' => $note['note']
            ]);
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

    public function createTransfer($request) {

        $notation = $this->notation->find($request['notation_id']);

        $this->add_transfer($notation, $request['forward_title'], $request['deadline_transfer'], $request['description'], $request['collaborators']);

        return $notation;
    }
}
