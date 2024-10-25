<?php

namespace App\Models\Litigation;

use App\Concerns\Traits\Alert\Alertable;
use App\Concerns\Traits\Litigation\LitigationFormFieldTrait;
use App\Models\ModuleTask;
use App\Observers\LitigationTaskObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy([LitigationTaskObserver::class])]
class LitigationTask extends ModuleTask
{
    use Alertable, LitigationFormFieldTrait;

    protected $table = 'module_tasks';

    public function step()
    {
        return $this->belongsTo(LitigationStep::class, 'step_id', 'id');
    }

    public function getFormAttribute()
    {
        $form = $this->getCustomFormFields($this);

        return $form;
    }
}
