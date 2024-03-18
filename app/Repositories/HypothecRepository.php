<?php
namespace App\Repositories;

use App\Models\Guarantee\ConventionnalHypothecs\ConventionnalHypothec;
use App\Models\Guarantee\ConventionnalHypothecs\HypothecStep;
use Illuminate\Database\Eloquent\Collection;

class HypothecRepository
{
    public function __construct(
        private HypothecStep $step_model,
        private ConventionnalHypothec $conv_model
    ) {
    }
    function getSteps() : Collection {
        return $this->step_model->all();
    }

    function initFormalizationProcess($request) {
        $this->storeFile($request->file);
        $this->conv_model->actor_type = $request->actor_type;
        $this->conv_model->date_signification = $request->date_signification;
        $this->conv_model->save();
    }

    function storeFile($file) {
        if($file) {
            $path = $file->store('guaranty/conventionnal');
            return $path;
        }
    }
}
