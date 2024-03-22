<?php
namespace App\Concerns\Traits\Guarantee;

use App\Enums\ConvHypothecState;
use App\Rules\Administrator\ArrayElementMatch;

trait StepsValidationRuleTrait
{
    public function validationRulesByStep($state) : array {
        $data = array();

        switch ($state) {
            case ConvHypothecState::CREATED:
                $data = array(
                    'property_files' => 'array|required',
                );
                break;
            case ConvHypothecState::PROPERTY_VERIFIED:
                $data = array(
                    'agreement_file' => 'required|file|max:8192|mimes:pdf,doc,docx',
                );
                break;
            case ConvHypothecState::AGREEMENT_SIGNED:
                $data = array(
                    'registration_request_discharge_file' => 'required|file|max:8192|mimes:pdf,doc,docx',
                    'registering_date' => 'required|date|date_format:Y-m-d|before_or_equal:today',
                );
                break;
            case ConvHypothecState::REGISTER_REQUESTED:
                $data = array(
                    'is_approved' => ['required',  new ArrayElementMatch(array('yes', 'no'))],
                    'registration_accepted_proof_file' => 'required|file|max:8192|mimes:pdf,doc,docx',
                    'registration_date' => 'required|date|date_format:Y-m-d|before_or_equal:today',
                );
                break;
            case ConvHypothecState::REGISTER:
                $data = array(
                    'actor_type' => ['required',  new ArrayElementMatch(array('holder', 'third_party_holder'))],
                    'signification_files' => 'required|array',
                    'date_signification' => 'required|date|date_format:Y-m-d|before_or_equal:today',
                );
                break;
            case ConvHypothecState::SIGNIFICATION_REGISTERED:
                $data = array(
                    'is_verified' => 'required|string',
                );
                break;

            case ConvHypothecState::ORDER_PAYMENT_VERIFIED:
                $data = array(
                    'visa_date' => 'required|date|date_format:Y-m-d|before_or_equal:today',
                    'order_payment_files' => 'required|array',
                );
                break;

            case ConvHypothecState::ORDER_PAYMENT_VISA:
                $data = array(
                    'date_deposit_specification' => 'required|date|date_format:Y-m-d|before_or_equal:today',
                    'date_sell' => 'required|date|date_format:Y-m-d|before_or_equal:today',
                    'expropriation_files' => 'required|array',
                );
                break;

            default:

                break;
        }

        return $data;
    }
}
