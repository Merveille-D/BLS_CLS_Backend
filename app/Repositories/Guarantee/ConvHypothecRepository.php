<?php
namespace App\Repositories\Guarantee;

use App\Concerns\Traits\Guarantee\HypothecFormFieldTrait;
use App\Enums\ConvHypothecState;
use App\Http\Resources\Guarantee\ConvHypothecCollection;
use App\Http\Resources\Guarantee\ConvHypothecResource;
use App\Http\Resources\Guarantee\ConvHypothecStepResource;
use App\Jobs\SendNotification;
use App\Models\Alert\Notification;
use App\Models\Guarantee\ConvHypothec;
use App\Models\Guarantee\ConvHypothecStep;
use App\Models\Guarantee\GuaranteeDocument;
use App\Models\User;
use App\Notifications\Guarantee\ConvHypothecNextStep;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Notification as FacadesNotification;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ConvHypothecRepository
{
    use HypothecFormFieldTrait;
    public function __construct(
        private ConvHypothec $conv_model
    ) {
    }


    public function getConvHypothecs($request) : ResourceCollection {
        $search = $request->search;
        $type = $request->type;
        return ConvHypothecResource::collection($this->conv_model
                    ->when(!blank($type) && $type == 'realizable', function($qry) {
                        $qry->whereState(ConvHypothecState::REGISTER)->whereIsApproved(true);
                    })
                    ->when(!blank($search), function($qry) use($search) {
                        $qry->where('name', 'like', '%'.$search.'%');
                    })
                    ->paginate());
    }

    public function getConvHypothecById($id) : JsonResource {
        return new ConvHypothecResource($this->conv_model->with('documents')->findOrFail($id));
    }


    public function getHypthecSteps($hypothecId, $request) {
        $hypothec = $this->conv_model->find($hypothecId);
        if ($hypothec == null)
            return array();

        $steps = ($hypothec->steps);
        $type = $request->type;

        $steps->transform(function ($step) {
            $step->status = $step->status ? true : false;
            $form = $this->getCustomFormFields($step->code);
            if ($form) {
                $step->form = $form;
            }
            return $step;
        });

        return ConvHypothecStepResource::collection($steps);
        // return new ConvHypothecResource($this->conv_model->with('documents')->findOrFail($id));
    }

    public function getOneStep($hypothec_id, $step_id) {
        $hypothec = $this->conv_model->find($hypothec_id);
        if ($hypothec == null)
            return array();

        $step = ($hypothec->steps)->where('id', $step_id)->first();
        $form = $this->getCustomFormFields($step->code);
        if ($form) {
            $step->form = $form;
        }
        return new ConvHypothecStepResource($step);
    }

    function initFormalizationProcess($request) {

        $file_path = storeFile($request->contract_file, 'guarantee/conv_hypothec');
        $data = array(
            'state' => 'created',
            'step' => 'formalization',
            'reference' => generateReference('HC'),
            'name' => $request->name,
            'contract_file' =>  $file_path,
            'contract_id' =>  $request->contract_id,
        );

        $convHypo = $this->conv_model->create($data);

        $all_steps = ConvHypothecStep::orderBy('rank')->whereType('formalization')->get();

        $convHypo->steps()->syncWithoutDetaching($all_steps);
        $this->updatePivotState($convHypo);


        // $user->notify((new ConvHypothecNextStep($convHypo))/* ->delay(Carbon::now()->addMinutes(1)) */);
        return new ConvHypothecResource($convHypo);
    }

    public function realization($convHypoId) {
        $convHypo = $this->conv_model->findOrfail($convHypoId);
        if ($convHypo->is_approved && $convHypo->state == ConvHypothecState::REGISTER) {
            $real_steps = ConvHypothecStep::orderBy('rank')->whereType('realization')->get();

            $convHypo->steps()->syncWithoutDetaching($real_steps);
            $convHypo->step = 'realization';
            $convHypo->save();
            return ConvHypothecStepResource::collection($convHypo->steps);
        } else {
            return [];
        }
    }

    public function updatePivotState($convHypo) {
        $currentStep = $convHypo->next_step; //because the current step is not  updated yet

        if ($currentStep) {
            $pivotValues = [
                $currentStep->id => [
                    'status' => true,
                ]
            ];
            $convHypo->steps()->syncWithoutDetaching($pivotValues);
        }

        ////TODO: will be removed when realized route will be available
        // if ($convHypo->state == ConvHypothecState::REGISTER && $convHypo->is_approved == true) {
        //     $all_steps = ConvHypothecStep::orderBy('rank')->whereType('realization')->get();

        //     $convHypo->steps()->syncWithoutDetaching($all_steps);
        // }

        $nextStep = $convHypo->next_step;
        if ($nextStep) {
            $data = $this->setDeadline($convHypo);

            if ($data == [])
                return false;

            $pivotValues = [
                $nextStep->id => $data
            ];
            $convHypo->steps()->syncWithoutDetaching($pivotValues);
        }
    }

    public function updateProcess($request, $convHypo) {
        $data = array();

        if ($convHypo) {
            $data = $this->updateProcessByState($request, $convHypo);

            $this->updatePivotState($convHypo);
            return new ConvHypothecResource($data);
        }
    }

    function updateProcessByState($request, $convHypo) {
        $data = array();

        switch ($convHypo->state) {
            case ConvHypothecState::CREATED:
                $data = $this->verifyProperty($request, $convHypo);
                break;
            case ConvHypothecState::PROPERTY_VERIFIED:
                $data = $this->insertAgreement($request, $convHypo);
                break;
            case ConvHypothecState::AGREEMENT_SIGNED:
                $data = $this->insertRegisterRequestDischarge($request, $convHypo);
                break;
            case ConvHypothecState::REGISTER_REQUESTED:
                $data = $this->manageRegisterResponse($request, $convHypo);
                break;
            case ConvHypothecState::REGISTER:
                $data = $this->saveSignification($request, $convHypo);
                break;

            case ConvHypothecState::SIGNIFICATION_REGISTERED:
                $data = $this->verifyPayementOrder($request);
                break;
                //
            case ConvHypothecState::ORDER_PAYMENT_VERIFIED:
                $data = $this->saveOrderPayement($request, $convHypo);
                break;

            case ConvHypothecState::ORDER_PAYMENT_VISA:
                $data = $this->saveExpropriationSpec($request, $convHypo);
                break;
            // case ConvHypothecState::EXPROPRIATION_SPECIFICATION:
            //     $data = $this->saveExpropriationSale($request);
            //     break;

            case ConvHypothecState::EXPROPRIATION_SPECIFICATION:
                $data = $this->saveExpropriationSummation($request, $convHypo);
                break;
                //advertisement step
            case ConvHypothecState::EXPROPRIATION_SUMMATION:
                $data = $this->saveAdvertisement($request, $convHypo);
                break;
            case ConvHypothecState::ADVERTISEMENT:
                $data = $this->sellProperty($request, $convHypo);
                break;

            default:
                # code...
                break;
        }
        $convHypo->update($data);
        return $convHypo->refresh();
    }

    function verifyProperty($request, $convHypo) : array {
        $state = ConvHypothecState::PROPERTY_VERIFIED;
        return $this->stepCommonSavingSettings(
            $files = $request->documents,
            $convHypo = $convHypo,
            $data = ['state' => $state]
        );
    }

    function insertAgreement($request, $convHypo) : array {
        $state = ConvHypothecState::AGREEMENT_SIGNED;
        $data = array(
            'state' => $state,
        );

        return $this->stepCommonSavingSettings(
            $files = $request->documents,
            $convHypo = $convHypo,
            $data = $data
        );
    }

    function insertRegisterRequestDischarge($request, $convHypo) : array {
        $data = array(
            'registering_date' => $request->registering_date,
            'state' => ConvHypothecState::REGISTER_REQUESTED,
        );

        return $this->stepCommonSavingSettings(
            $files = $request->documents,
            $convHypo = $convHypo,
            $data = $data
        );
    }

    function manageRegisterResponse($request, $convHypo) : array {
        $data = array(
                'registration_date' => $request->registration_date,
                'state' => $request->is_approved == 'yes' ? ConvHypothecState::REGISTER : ConvHypothecState::NONREGISTER,
                'is_approved' => $request->is_approved == 'yes' ? true : false,
            );

        return $this->stepCommonSavingSettings(
            $files = $request->documents,
            $convHypo = $convHypo,
            $data = $data
        );
    }

    function saveSignification($request, $convHypo) : array {
        if ($convHypo->is_approved == false) {
            return [];
        }

        $data = array(
                'date_signification' => $request->date_signification,
                // 'step' => 'realization',
                'state' => ConvHypothecState::SIGNIFICATION_REGISTERED,
            );

        return $this->stepCommonSavingSettings(
            $files = $request->documents,
            $convHypo = $convHypo,
            $data = $data
        );
    }

    function verifyPayementOrder($request) {
        $data = array(
            'is_verified' => $request->is_verified == 'yes' ? true : false,
            'state' => ConvHypothecState::ORDER_PAYMENT_VERIFIED,
        );

        return $data;
    }

    function saveOrderPayement($request, $convHypo) : array|bool {
        if ($convHypo->is_verified == false) {
            return [];
        }
        $data = array(
            'visa_date' => $request->visa_date,
            'state' => ConvHypothecState::ORDER_PAYMENT_VISA,
        );

        return $this->stepCommonSavingSettings(
            $files = $request->documents,
            $convHypo = $convHypo,
            $data = $data
        );
    }

    public function saveExpropriationSpec($request, $convHypo) : array {
        $data = array(
            'date_deposit_specification' => $request->date_deposit_specification,
            'date_sell' => $request->date_sell,
            'state' => ConvHypothecState::EXPROPRIATION_SPECIFICATION,
        );

        return $this->stepCommonSavingSettings(
            $files = $request->documents,
            $convHypo = $convHypo,
            $data = $data
        );
    }

    // public function saveExpropriationSale($request) : array {
    //     $data = array(
    //         'date_sell' => $request->date_sell,
    //         'state' => ConvHypothecState::EXPROPRIATION_SALE,
    //     );

    //     return $data;
    // }

    public function saveExpropriationSummation($request, $convHypo) {
        $data = array(
            'summation_date' =>  $request->summation_date,
            'state' => ConvHypothecState::EXPROPRIATION_SUMMATION,
        );

        return $this->stepCommonSavingSettings(
            $files = $request->documents,
            $convHypo = $convHypo,
            $data = $data
        );
    }

    public function saveAdvertisement($request, $convHypo) : array {
        $data = array(
            'advertisement_date' => $request->advertisement_date,
            'state' => ConvHypothecState::ADVERTISEMENT,
        );

        return $this->stepCommonSavingSettings(
            $files = $request->documents,
            $convHypo = $convHypo,
            $data = $data
        );
    }

    public function sellProperty($request, $convHypo) : array {
        $data = array(
            'sell_price_estate' => $request->sell_price_estate,
            'state' => ConvHypothecState::PROPERTY_SALE,
        );

        return $this->stepCommonSavingSettings(
            $files = $request->documents,
            $convHypo = $convHypo,
            $data = $data
        );
    }

    function stepCommonSavingSettings($files,Model $convHypo, array $data) : array|bool {
        if (count($files)<=0)
            return [];

        foreach ($files as $key => $file_elt) {

            $file_path = storeFile($file_elt['file'], 'guarantee/conv_hypothec');

            $doc = new GuaranteeDocument();
            $doc->state = $data['state'];
            $doc->file_name = $file_elt['name'];
            $doc->file_path = $file_path;

            $convHypo->documents()->save($doc);
        }

        //check files are saved correctly before changing state
        $check_files = $convHypo->documents()->whereState($data['state'])->get();
        if ($check_files->count() > 0) {
            return $data;
        } else {
            return [];
        }

    }

    function setDeadline($convHypo) {
        $nextStep = $convHypo->next_step;

        $minDelay = $nextStep->min_delay;
        $maxDelay = $nextStep->max_delay;
        $data = array();
        //date by hypothec state
        $operationDate = $this->getOperationDateByState($convHypo);
        if ($operationDate == null)
            return $data;
        $formatted_date = Carbon::createFromFormat('Y-m-d', $operationDate);

        if ($minDelay && $maxDelay) {
            $data['min_deadline'] = $formatted_date->copy()->addDays($minDelay);
            $data['max_deadline'] = $formatted_date->copy()->addDays($maxDelay);
            return $data;
        }elseif ($minDelay) {
            $data['min_deadline'] = $formatted_date->addDays($minDelay);
            return $data;
        }elseif ($maxDelay) {
            $data['max_deadline'] = $formatted_date->addDays($maxDelay);
            return $data;
        }
        return $data;
    }

    public function getOperationDateByState($convHypo) {
        $state = $convHypo->state;
        $date = null;
        switch ($state) {
            case ConvHypothecState::REGISTER_REQUESTED:
                $date = $convHypo->registering_date;
                break;
            case ConvHypothecState::SIGNIFICATION_REGISTERED:
                $date = $convHypo->date_signification;
                break;
            // case ConvHypothecState::ORDER_PAYMENT_VISA:
            //     $date = $convHypo->visa_date;
            //     break;
            case ConvHypothecState::EXPROPRIATION_SPECIFICATION:
                $date = $convHypo->visa_date;
                break;
            case ConvHypothecState::EXPROPRIATION_SUMMATION:
                $date = $convHypo->summation_date;
                break;
            case ConvHypothecState::ADVERTISEMENT:
                $date = $convHypo->advertisement_date;
                break;
            default:
                # code...
                break;
        }
        return $date;
    }

    public function saveMultipleFiles($files, $convHypo, $state) {
        foreach ($files as $key => $file) {

            $file_path = storeFile($file['file'], 'guarantee/conv_hypothec');

            $doc = new GuaranteeDocument();
            $doc->state = $state;
            $doc->file_name = $file['name'];
            $doc->file_path = $file_path;

            $convHypo->documents()->save($doc);
        }

        $check_files = ($convHypo->documents()->whereState(ConvHypothecState::PROPERTY_VERIFIED)->get());

        if ($check_files->count() > 0) {
            return true;
        } else {
            return false;
        }
    }
}
