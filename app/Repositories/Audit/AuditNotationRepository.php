<?php
namespace App\Repositories\Audit;

use App\Models\Audit\AuditNotation;

class AuditNotationRepository
{
    public function __construct(private AuditNotation $audit_notation) {

    }

    /**
     * @param Request $request
     *
     * @return AuditNotation
     */
    public function store($request) {

        $check_collaborator_notation = $this->audit_notation->where('module_id', $request['module_id'])
                                                            ->where('module', $request['module'])
                                                            ->first();

        if($check_collaborator_notation) {
            $check_collaborator_notation->update($request->all());

            $notes = $request['notes'];

            foreach ($notes as $note) {
                $check_collaborator_notation->performances()->update([
                    'performance_indicator_id' => $note['audit_performance_indicator_id'],
                    'note' => $note['note']
                ]);
            }

            return $check_collaborator_notation;
        }else {
            $audit_notation = $this->audit_notation->create($request->all());

            $notes = $request['notes'];

            foreach ($notes as $note) {
                $audit_notation->performances()->create([
                    'performance_indicator_id' => $note['audit_performance_indicator_id'],
                    'note' => $note['note']
                ]);
            }

            return $audit_notation;
        }
    }

}
