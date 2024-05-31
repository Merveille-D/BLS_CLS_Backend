<?php
namespace App\Repositories\Audit;

use App\Concerns\Traits\Transfer\AddTransferTrait;
use App\Models\Audit\AuditNotation;
use App\Models\Audit\AuditPerformanceIndicator;
use App\Models\Scopes\CountryScope;
use App\Models\User;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
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
                $audit_notation->created = $audit_notation->creator;

                $hiddenAttributes = [
                    'indicators', 'status', 'note', 'observation', 'date',
                    'created_by', 'parent_id', 'created_at', 'updated_at'
                ];
                $audit_notation->makeHidden($hiddenAttributes);

                return $audit_notation;
        });
    }

    public function auditNotationRessource($audit_notation) {

        $audit_notation->title = $audit_notation->title;
        $audit_notation->created = $audit_notation->creator;
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

        $audit_notation->original_note = $audit_notation->note;
        $audit_notation->original_indicators = $audit_notation->indicators;
        $audit_notation->original_status = $audit_notation->status;

        $audit_notation->last_status = $audit_notation->last_audit_notation->status;
        $audit_notation->last_note = $audit_notation->last_audit_notation->note;
        $audit_notation->last_indicators = $audit_notation->last_audit_notation->indicators;

        $hiddenAttributes = [
            'performances', 'indicators', 'status', 'note', 'observation',
            'parent_id', 'created_at', 'updated_at'
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

        $request['audit_reference'] ='ADT-' . '-' . now()->format('d') . '/' . now()->format('m') . '/' . now()->format('Y');
        $request['reference'] = generateReference('ADT', $this->audit_notation);

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

        $audit_notation->last_audit_notation->update($request);

        $this->updateNotes($audit_notation->last_audit_notation, $request['notes']);
        return $audit_notation;
    }

    public function createTransfer($request) {

        $audit_notation = $this->audit_notation->find($request['audit_notation_id']);
        $transfer = $this->add_transfer($audit_notation, $request['forward_title'], $request['deadline_transfer'], $request['description'], $request['collaborators']);

        // Add new notation for transfer
        $request['module_id'] = $audit_notation->module_id;
        $request['module'] = $audit_notation->module;
        $request['parent_id'] = $audit_notation->id;
        $request['created_by'] = Auth::user()->id;
        $request['status'] = $request['forward_title'];

        $new_audit_notation = $this->audit_notation->create($request);

        $indicators = AuditPerformanceIndicator::where('module', $audit_notation->module)->pluck('id');

        foreach ($indicators as $indicator) {
            $new_audit_notation->performances()->create([
                'audit_performance_indicator_id' => $indicator,
            ]);
        }

        $transfer->audit()->create([
            'audit_id' => $new_audit_notation->id,
        ]);

        return $audit_notation;
    }

    public function completeTransfer($request) {

        $audit_notation = $this->audit_notation->find($request['audit_notation_id']);

        $request['note'] = array_sum(array_column($request['notes'], 'note'));
        $request['created_by'] = Auth::user()->id;

        $audit_notation->update($request);

        $this->updateNotes($audit_notation, $request['notes']);

        return $audit_notation;
    }

    public function delete(AuditNotation $audit_notation) {
        $transfer_audits = AuditNotation::where('parent_id', $audit_notation->id)->get();

        $transfer_audits->each(function($audit) {
            $audit->delete();
        });

        $audit_notation->delete();
    }


    public function updateNotes($audit_notation, $notes) {
        foreach ($notes as $note) {
            $performance = $audit_notation->performances()->where('audit_performance_indicator_id', $note['audit_performance_indicator_id'])->first();

            if ($performance) {
                $performance->update([
                    'note' => $note['note']
                ]);
            }
        }
    }



}
