<?php

namespace App\Repositories\Evaluation;

use App\Concerns\Traits\PDF\GeneratePdfTrait;
use App\Concerns\Traits\Transfer\AddTransferTrait;
use App\Models\Evaluation\Notation;
use App\Models\Evaluation\PerformanceIndicator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class NotationRepository
{
    use AddTransferTrait;
    use GeneratePdfTrait;

    public function __construct(private Notation $notation) {}

    public function notationRessource($notation)
    {

        $notation->collaborator = $notation->collaborator;
        $notation->collaborator->position = $notation->collaborator->position;

        $notation->created = $notation->creator;
        $notation->transfers = $notation->transfers->makeHidden(['evaluation'])->map(function ($transfer) {

            $transfer->notation = Notation::find($transfer->evaluation->first()->evaluation_id);
            $hiddenAttributes = [
                'collaborator_id', 'performances', 'parent_id', 'created_at', 'updated_at',
            ];
            $transfer->notation->makeHidden($hiddenAttributes);

            $transfer->sender = $transfer->sender;
            $transfer->collaborators = $transfer->collaborators;

            return $transfer;
        });

        $notation->original_note = $notation->note;
        $notation->original_indicators = $notation->indicators;
        $notation->original_status = $notation->status;

        $notation->last_status = $notation->last_notation->status;
        $notation->last_note = $notation->last_notation->note;
        $notation->last_indicators = $notation->last_notation->indicators;

        $hiddenAttributes = [
            'collaborator_id', 'performances', 'indicators', 'note', 'status',
            'observation', 'parent_id', 'created_at', 'updated_at',
        ];
        $notation->makeHidden($hiddenAttributes);

        return $notation;
    }

    public function store($request)
    {

        $request['note'] = array_sum(array_column($request['notes'], 'note'));
        $request['created_by'] = Auth::user()->id;

        $request['evaluation_reference'] = 'EVT-' . '-' . now()->format('d') . '/' . now()->format('m') . '/' . now()->format('Y');
        $request['reference'] = generateReference('EVT', $this->notation);

        $notation = $this->notation->create($request);

        foreach ($request['notes'] as $note) {
            $notation->performances()->create([
                'performance_indicator_id' => $note['performance_indicator_id'],
                'note' => $note['note'],
            ]);
        }

        return $notation;
    }

    /**
     * @param  Request  $request
     * @return Notation
     */
    public function update(Notation $notation, $request)
    {

        $request['note'] = array_sum(array_column($request['notes'], 'note'));
        $request['created_by'] = Auth::user()->id;

        $notation->last_notation->update($request);

        $this->updateNotes($notation->last_notation, $request['notes']);

        return $notation;
    }

    public function createTransfer($request)
    {

        $notation = $this->notation->find($request['notation_id']);
        $transfer = $this->addTransfer($notation, $request['forward_title'], $request['deadline_transfer'], $request['description'], $request['collaborators']);

        // Add new notation for transfer
        $request['collaborator_id'] = $notation->collaborator_id;
        $request['parent_id'] = $notation->id;
        $request['created_by'] = Auth::user()->id;
        $request['status'] = $request['forward_title'];
        $request['evaluation_reference'] = 'EVT-' . '-' . now()->format('d') . '/' . now()->format('m') . '/' . now()->format('Y');
        $request['reference'] = generateReference('EVT', $this->notation);

        $new_notation = $this->notation->create($request);

        $position_id = $notation->collaborator->position_id;

        $indicators = PerformanceIndicator::where('position_id', $position_id)->pluck('id');

        foreach ($indicators as $indicator) {
            $new_notation->performances()->create([
                'performance_indicator_id' => $indicator,
            ]);
        }

        $transfer->evaluation()->create([
            'evaluation_id' => $new_notation->id,
        ]);

        return $notation;
    }

    public function completeTransfer($request)
    {

        $notation = $this->notation->find($request['notation_id']);

        $request['note'] = array_sum(array_column($request['notes'], 'note'));
        $request['created_by'] = Auth::user()->id;

        $notation->update($request);

        $this->updateNotes($notation, $request['notes']);

        return $notation;
    }

    public function delete(Notation $notation)
    {
        $transfer_evaluations = Notation::where('parent_id', $notation->id)->get();

        $transfer_evaluations->each(function ($evaluation) {
            $evaluation->delete();
        });

        $notation->delete();
    }

    public function updateNotes($notation, $notes)
    {
        foreach ($notes as $note) {
            $performance = $notation->performances()->where('performance_indicator_id', $note['performance_indicator_id'])->first();

            if ($performance) {
                $performance->update([
                    'note' => $note['note'],
                ]);
            }
        }
    }

    public function generatePdf($request)
    {

        $notation = Notation::find($request['notation_id']);

        $data = $this->notationRessource($notation);

        $filename = Str::slug($notation->evaluation_reference) . '_' . date('YmdHis') . '.pdf';

        $pdf = $this->generateFromView('pdf.evaluation.fiche_evaluation', [
            'data' => $data,
            'details' => $this->getDetails($data),
        ], $filename);

        return $pdf;
    }

    public function getDetails($data)
    {
        $details = [
            'N° de dossier' => $data['evaluation_reference'],
            'Statut actuel' => $data['status'],
            'Collaborateur' => $data['collaborator']['lastname'] . ' ' . $data['collaborator']['firstname'],
            'Poste' => $data['collaborator']['position']['title'],
            'Créé par' => $data['creator']['firstname'] . '' . $data['creator']['lastname'],
        ];

        return $details;
    }
}
