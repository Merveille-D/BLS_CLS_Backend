<?php
namespace App\Repositories\Guarantee;

use App\Enums\ConvHypothecState;
use App\Http\Resources\Guarantee\ConvHypothecCollection;
use App\Http\Resources\Guarantee\ConvHypothecResource;
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

class ConvHypothecRepository
{
    public function __construct(
        private ConvHypothec $conv_model
    ) {
    }


    public function getConvHypothecs() : ResourceCollection {
        return ConvHypothecResource::collection($this->conv_model->paginate());
    }

    public function getConvHypothecById($id) : JsonResource {
        return new ConvHypothecResource($this->conv_model->with('documents')->findOrFail($id));
    }


    public function getHypthecSteps($hypothecId, $request) {
        if ($this->conv_model->find($hypothecId) == null) {
            return array();
        }
        $type = $request->type;
        $steps = ConvHypothecStep::select('conv_hypothec_steps.id', 'code', 'conv_hypothec_steps.name', 'conv_hypothec_steps.type',
                 'conv_hypothecs.id as hypothec_id', 'hypothec_step.created_at')
                ->leftJoin('hypothec_step', 'conv_hypothec_steps.id', '=', 'hypothec_step.step_id')
                ->leftJoin('conv_hypothecs', function ($join) use ($hypothecId) {
                    $join->on('conv_hypothecs.id', '=', 'hypothec_step.hypothec_id')
                        ->where('hypothec_step.hypothec_id', $hypothecId);
                })
                ->when(!blank($type), function($qry) use($type) {
                    $qry->where('conv_hypothec_steps.type', $type);
                })
                ->orderBy('conv_hypothec_steps.id')
                ->get();
        return $steps;
        // return new ConvHypothecResource($this->conv_model->with('documents')->findOrFail($id));
    }

    function initFormalizationProcess($request) {

        $file_path = $this->storeFile($request->contract_file);
        $data = array(
            'state' => 'created',
            'step' => 'formalization',
            'reference' => generateReference('HC'),
            'name' => $request->name,
            'contract_file' =>  $file_path,
            'contract_id' =>  $request->contract_id,
        );

        $convHypo = $this->conv_model->create($data);

        $convHypo->steps()->save($this->currentStep($convHypo->state));

        // $user->notify((new ConvHypothecNextStep($convHypo))/* ->delay(Carbon::now()->addMinutes(1)) */);
        return new ConvHypothecResource($convHypo);
    }

    public function currentStep($state) : Model {
        return ConvHypothecStep::whereCode($state)->first();
    }

    public function nextStep($state) : Model {
        $current =  ConvHypothecStep::whereCode($state)->first();
        return $next = ConvHypothecStep::where('rank', $current->rank+1)->first();
    }


    public function updateProcess($request, $convHypo) {
        $data = array();

        if ($convHypo) {
            $data = $this->updateProcessByState($request, $convHypo);

            $data->steps()->save($this->currentStep($data->state));
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
                $data = $this->saveExpropriation($request, $convHypo);
                break;
                //advertisement step
            case ConvHypothecState::EXPROPRIATION:
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
            return false;
        }

        $data = array(
                'date_signification' => $request->date_signification,
                'step' => 'realization',
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

    function saveOrderPayement($request, $convHypo) : array {
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

    public function saveExpropriation($request, $convHypo) : array {
        $data = array(
            'date_deposit_specification' => $request->date_deposit_specification,
            'date_sell' => $request->date_sell,
            'state' => ConvHypothecState::EXPROPRIATION,
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

    function stepCommonSavingSettings($files,Model $convHypo, array $data) : array {
        if (count($files)<=0)
            return false;
        foreach ($files as $key => $file_elt) {

            $file_path = $this->storeFile($file_elt['file']);

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

    public function saveMultipleFiles($files, $convHypo, $state) {
        foreach ($files as $key => $file) {

            $file_path = $this->storeFile($file['file']);

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

    function storeFile($file) {
        if($file) {
            $sanitized_file_name = date('Y-m-d_His-').Str::random(6).auth()->id().'-'.sanitize_file_name($file->getClientOriginalName());
            $path = $file->storeAs('guarantee/conventionnal_hypothec', $sanitized_file_name);
            return $path;
        }
    }
}
