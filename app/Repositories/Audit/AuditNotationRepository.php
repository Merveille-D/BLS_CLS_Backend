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
                    'performance_indicator_id' => $note['audit_performance_indicator_id'],
                    'note' => $note['note']
                ]);
            }

            return $check_collaborator_notation;
        }else {
            $audit_notation = $this->audit_notation->create($request->all());
            
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
