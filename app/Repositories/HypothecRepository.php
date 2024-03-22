<?php
namespace App\Repositories;

use App\Enums\ConvHypothecState;
use App\Http\Resources\Guarantee\ConvHypothecCollection;
use App\Models\Guarantee\ConventionnalHypothecs\ConventionnalHypothec;
use App\Models\Guarantee\GuaranteeDocument;
use Illuminate\Database\Eloquent\Model;

class HypothecRepository
{
    public function __construct(
        private ConventionnalHypothec $conv_model
    ) {
    }


    function getConvHypothecs() : ConvHypothecCollection {
        return new ConvHypothecCollection($this->conv_model->paginate());
    }

    function getConvHypothecById($id) : Model {
        return $this->conv_model->findOrFail($id);
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
        return $convHypo;
    }

    public function updateProcess($request, $convHypo) : ConventionnalHypothec {
        $data = array();

        if ($convHypo) {
            $data = $this->updateProcessByState($request, $convHypo);
            return $data;
        }
    }

    function updateProcessByState($request, $convHypo) {
        $data = array();

        switch ($convHypo->state) {
            case ConvHypothecState::CREATED:
                $data = $this->verifyProperty($request, $convHypo);
                break;
            case ConvHypothecState::PROPERTY_VERIFIED:
                $data = $this->insertAgreement($request);
                break;
            case ConvHypothecState::AGREEMENT_SIGNED:
                $data = $this->insertRegisterRequestDischarge($request);
                break;
            case ConvHypothecState::REGISTER_REQUESTED:
                $data = $this->manageRegisterResponse($request);
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

            default:
                # code...
                break;
        }


        $convHypo->update($data);
        return $convHypo->refresh();
    }

    function verifyProperty($request, $convHypo) : array {
        if (count($request->property_files)<=0)
            return false;

        foreach ($request->property_files as $key => $property_file) {

            $file_path = $this->storeFile($property_file['file']);

            $doc = new GuaranteeDocument();
            $doc->state = ConvHypothecState::PROPERTY_VERIFIED;
            $doc->file_name = $property_file['name'];
            $doc->file_path = $file_path;

            $convHypo->documents()->save($doc);
        }

        $check_files = ($convHypo->documents()->whereState(ConvHypothecState::PROPERTY_VERIFIED)->get());
        //check files are saved correctly before changing state
        if ($check_files->count() > 0) {
            return $data = array(
                'state' => ConvHypothecState::PROPERTY_VERIFIED,
            );
        } else {
            return [];
        }

    }

    function insertAgreement($request) : array {
        $file_path = $this->storeFile($request->agreement_file);
        $data = [];
        if ($file_path) {
            $data = array(
                'state' => ConvHypothecState::AGREEMENT_SIGNED,
                'agreement_file' =>  $file_path,
            );
        }

        return $data;
    }

    function insertRegisterRequestDischarge($request) : array {
        $file_path = $this->storeFile($request->registration_request_discharge_file);
        $data = [];
        if ($file_path) {
            $data = array(
                'registering_date' => $request->registering_date,
                'state' => ConvHypothecState::REGISTER_REQUESTED,
                'registration_request_discharge_file' =>  $file_path,
            );
        }

        return $data;
    }

    function manageRegisterResponse($request) : array {
        $file_path = $this->storeFile($request->registration_accepted_proof_file);
        $data = [];
        if ($file_path) {
            $data = array(
                'registration_date' => $request->registration_date,
                'state' => $request->is_approved == 'yes' ? ConvHypothecState::REGISTER : ConvHypothecState::NONREGISTER,
                'is_approved' => $request->is_approved == 'yes' ? true : false,
                'registration_accepted_proof_file' =>  $file_path,
            );
        }

        return $data;
    }

    function saveSignification($request, $convHypo) : array {
        // $file_path = $this->storeFile($request->signification_file);
        if ($convHypo->is_approved == false) {
            return false;
        }
        $saveMultiple = $this->saveMultipleFiles($request->signification_files, $convHypo, ConvHypothecState::SIGNIFICATION_REGISTERED);

        $data = [];
        if ($saveMultiple) {
            $data = array(
                'date_signification' => $request->date_signification,
                'step' => 'realization',
                'state' => ConvHypothecState::SIGNIFICATION_REGISTERED,
            );
        }

        return $data;
    }

    function verifyPayementOrder($request) {
        $data = array(
            'is_verified' => $request->is_verified == 'yes' ? true : false,
            'state' => ConvHypothecState::ORDER_PAYMENT_VERIFIED,
        );

        return $data;
    }

    function saveOrderPayement($request, $convHypo) : array {
        $saveMultiple = $this->saveMultipleFiles($request->order_payment_files, $convHypo, ConvHypothecState::ORDER_PAYMENT_VISA);

        $data = [];
        if ($saveMultiple) {
            $data = array(
                'visa_date' => $request->visa_date,
                'state' => ConvHypothecState::ORDER_PAYMENT_VISA,
            );
        }

        return $data;
    }

    function saveExpropriation($request, $convHypo) : array {
        $saveMultiple = $this->saveMultipleFiles($request->expropriation_files, $convHypo, ConvHypothecState::EXPROPRIATION);

        $data = [];
        if ($saveMultiple) {
            $data = array(
                'date_deposit_specification' => $request->date_deposit_specification,
                'date_sell' => $request->date_sell,
                'state' => ConvHypothecState::EXPROPRIATION,
            );
        }

        return $data;
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
            $sanitized_file_name = date('Y-m-d_His-').sanitize_file_name($file->getClientOriginalName());
            $path = $file->storeAs('guarantee/conventionnal_hypothec', $sanitized_file_name);
            return $path;
        }
    }
}
