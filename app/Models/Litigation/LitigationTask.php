<?php

namespace App\Models\Litigation;

use App\Concerns\Traits\Alert\Alertable;
use App\Concerns\Traits\Guarantee\GuaranteeFormFieldTrait;
use App\Concerns\Traits\Litigation\LitigationFormFieldTrait;
use App\Concerns\Traits\Transfer\Transferable;
use App\Models\ModuleTask;
use App\Observers\LitigationTaskObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy([LitigationTaskObserver::class])]
class LitigationTask extends ModuleTask
{
    use LitigationFormFieldTrait, Alertable;

    protected $table = 'module_tasks';

    public function step()
    {
        return $this->belongsTo(LitigationStep::class, 'step_id', 'id');
    }

    public function getFormAttribute() {
        $form = $this->getCustomFormFields($this);

        return $form;
    }
}
