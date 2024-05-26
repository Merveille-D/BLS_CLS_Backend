<?php
namespace App\Repositories\Audit;

use App\Concerns\Traits\Transfer\AddTransferTrait;
use App\Models\Audit\AuditNotation;
use App\Models\Audit\AuditPerformanceIndicator;
use Illuminate\Support\Facades\Auth;

class AuditNotationRepository
{
    use AddTransferTrait;

    public function __construct(private AuditNotation $audit_notation) {

    }

    public function all() {
        return $this->audit_notation->whereNull('parent_id')->get()
            ->makeHidden(['performances', 'indicators'])
            ->map(function ($audit_notation) {

                $audit_notation->title = $audit_notation->title;

                $hiddenAttributes = [
                    'indicators', 'status', 'note', 'observation', 'date',
                    'created_by', 'parent_id', 'created_at', 'updated_at'
                ];
                $audit_notation->makeHidden($hiddenAttributes);

                return $audit_notation;
        });
    }

    public function auditNotationRessource($audit_notation) {

        $audit_notation->collaborator = $audit_notation->title;
        $audit_notation->transfers = $audit_notation->transfers->makeHidden(['audit'])->map(function ($transfer) {

            $transfer->notation = AuditNotation::find($transfer->audit->first()->audit_id);
            $hiddenAttributes = [
                'performances', 'parent_id', 'created_at', 'updated_at'
            ];
            $transfer->notation->makeHidden($hiddenAttributes);

            $transfer->sender = $transfer->sender;
            $transfer->collaborators = $transfer->collaborators;

            return $transfer;
        });

        $audit_notation->last_note = $audit_notation->last_notation->note;
        $audit_notation->last_indicators = $audit_notation->last_notation->indicators;

        $hiddenAttributes = [
            'performances', 'indicators', 'status', 'note', 'observation',
            'created_by', 'parent_id', 'created_at', 'updated_at'
        ];
        $audit_notation->makeHidden($hiddenAttributes);

        return $audit_notation;
    }


    /**
     * @param Request $request
     *
     * @return AuditNotation
     */
    public function store($request) {

        $request['note'] = array_sum(array_column($request['notes'], 'note'));
        $request['created_by'] = Auth::user()->id;

        $audit_notation = $this->audit_notation->create($request);

        foreach ($request['notes'] as $note) {
            $audit_notation->performances()->create([
                'audit_performance_indicator_id' => $note['audit_performance_indicator_id'],
                'note' => $note['note']
            ]);
        }

        return $audit_notation;
    }

    public function update(AuditNotation $audit_notation, $request) {

        $request['note'] = array_sum(array_column($request['notes'], 'note'));
        $request['created_by'] = Auth::user()->id;

        $audit_notation->update($request);

        foreach ($request['notes'] as $note) {
            $audit_notation->performances()->update([
                'audit_performance_indicator_id' => $note['audit_performance_indicator_id'],
                'note' => $note['note']
            ]);
        }

        return $audit_notation;
    }

    public function createTransfer($request) {

        $audit_notation = $this->audit_notation->find($request['notation_id']);
        $transfer = $this->add_transfer($audit_notation, $request['forward_title'], $request['deadline_transfer'], $request['description'], $request['collaborators']);

        // Add new notation for transfer
        $request['collaborator_id'] = $audit_notation->collaborator_id;
        $request['parent_id'] = $audit_notation->id;
        $request['created_by'] = Auth::user()->id;
        $request['status'] = $request['forward_title'];

        $new_notation = $this->audit_notation->create($request);

        $position = $audit_notation->collaborator->position;

        $indicators = AuditPerformanceIndicator::where('position', $position)->pluck('id');

        foreach ($indicators as $indicator) {
            $new_notation->performances()->create([
                'performance_indicator_id' => $indicator,
            ]);
        }

        $transfer->audit()->create([
            'evaluation_id' => $new_notation->id,
        ]);

        return $audit_notation;
    }

    public function completeTransfer($request) {

        $audit_notation = $this->audit_notation->find($request['notation_id']);

        $request['note'] = array_sum(array_column($request['notes'], 'note'));
        $request['created_by'] = Auth::user()->id;

        $audit_notation->update($request);

        foreach ($request['notes'] as $note) {
            $audit_notation->performances()->update([
                'performance_indicator_id' => $note['performance_indicator_id'],
                'note' => $note['note']
            ]);
        }

        return $audit_notation;
    }

}
