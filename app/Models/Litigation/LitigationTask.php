<?php

namespace App\Models\Litigation;

use App\Concerns\Traits\Guarantee\GuaranteeFormFieldTrait;
use App\Concerns\Traits\Litigation\LitigationFormFieldTrait;
use App\Concerns\Traits\Transfer\Transferable;
use App\Models\ModuleTask;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LitigationTask extends ModuleTask
{
    use LitigationFormFieldTrait;

    protected $table = 'module_tasks';

    public function getFormAttribute() {
        $form = $this->getCustomFormFields($this);

        return $form;
    }
}
