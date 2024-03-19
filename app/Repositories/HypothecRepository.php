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
        $this->storeFile($request->signification_file);
        $this->conv_model->name = $request->name;
        $this->conv_model->type_actor = $request->type_actor;
        $this->conv_model->date_signification = $request->date_signification;
        $this->conv_model->save();
    }

    function storeFile($file) {
        if($file) {
            $sanitized_file_name = date('Y-m-d_His-').sanitize_file_name($file->getClientOriginalName());
            $path = $file->storeAs('guaranty/conventionnal_hypothec', $sanitized_file_name);
            return $path;
        }
    }
}
