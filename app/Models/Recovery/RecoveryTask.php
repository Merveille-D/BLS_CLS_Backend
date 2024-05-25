<?php

namespace App\Models\Recovery;

use App\Concerns\Traits\Recovery\RecoveryFormFieldTrait;
use App\Models\ModuleTask;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecoveryTask extends ModuleTask
{
    use HasFactory, RecoveryFormFieldTrait;

    protected $table = 'module_tasks';

    public function step()
    {
        return $this->belongsTo(RecoveryStep::class, 'step_id');
    }

    public function getFormAttribute() {
        $form = $this->getCustomFormFields($this->code);

        return $form;
    }
}
