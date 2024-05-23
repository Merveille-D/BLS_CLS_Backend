<?php
namespace App\Repositories\Audit;

use App\Concerns\Traits\Transfer\AddTransferTrait;
use App\Models\Audit\AuditNotation;
use Illuminate\Support\Facades\Auth;

class AuditNotationRepository
{
    use AddTransferTrait;

    public function __construct(private AuditNotation $audit_notation) {

    }

    public function all() {
        return $this->audit_notation->whereNull('parent_id')->get()->makeHidden('performances','indicators')->map(function ($audit_notation) {

            $audit_notation->title = $audit_notation->title;

            // unset(
            //     $audit_notation->status,
            //     $audit_notation->note,
            //     $audit_notation->observation,
            //     $audit_notation->module_id,
            //     $audit_notation->module,
            //     $audit_notation->date,
            //     $audit_notation->created_by,
            //     $audit_notation->parent_id,
            // );

            $audit_notation->steps = $audit_notation->steps->map(function ($step) {
                $step->indicators = $step->indicators;
                return $step;
            });

            return $audit_notation;
        });
    }

    /**
     * @param Request $request
     *
     * @return AuditNotation
     */
    public function store($request) {

        $request = $request->all();

        $check_module_notation = $this->audit_notation->where('module_id', $request['module_id'])
                                                            ->where('module', $request['module'])
                                                            ->first();
        $notes = $request['notes'];
        $sum = 0;
        foreach ($notes as $note) {
            $sum += $note['note'];
        }
        $request['note'] = $sum;

        if($check_module_notation) {

            $transfers = $check_module_notation->transfers;

            if($transfers->count() == 0) {

                $this->updateAudit($check_module_notation, $request, $notes);
            }else {

                $created_by_last_transfer = $transfers->last()->collaborators->first()->id;

                if($created_by_last_transfer == Auth::user()->id) {

                    if($transfers->last()->status == true) {
                        $request['created_by'] = Auth::user()->id;
                        $request['parent_id'] = $check_module_notation->id;
                        $request['status'] = $transfers->last()->title;

                        $this->createAudit($request, $notes);
                    }else {
                        $module_notation = $check_module_notation->where('created_by', Auth::user()->id)->first();

                        if($module_notation) {
                            $this->updateAudit($module_notation, $request, $notes);
                        }

                    }
                }
            }
        }else {

            $request['created_by'] = Auth::user()->id;
            $check_module_notation = $this->createAudit($request, $notes);
        }

        return $check_module_notation;
    }

    public function createAudit($request, $notes) {


        $audit_notation = $this->audit_notation->create($request);

        foreach ($notes as $note) {
            $audit_notation->performances()->create([
                'performance_indicator_id' => $note['audit_performance_indicator_id'],
                'note' => $note['note']
            ]);
        }

        return $audit_notation;
    }

    public function updateAudit($check_module_notation, $request, $notes) {

        $check_module_notation->update($request);

        foreach ($notes as $note) {
            $check_module_notation->performances()->update([
                'performance_indicator_id' => $note['audit_performance_indicator_id'],
                'note' => $note['note']
            ]);
        }
    }

    public function createTransfer($request) {

        $audit_notation = $this->audit_notation->where('module_id', $request['module_id'])
                                                            ->where('module', $request['module'])
                                                            ->first();
        if($audit_notation) {
            $this->add_transfer($audit_notation, $request['forward_title'], $request['deadline_transfer'], $request['description'], $request['collaborators']);
        }

        return $audit_notation;
    }

}
