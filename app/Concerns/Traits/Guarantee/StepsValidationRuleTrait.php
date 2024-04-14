<?php
namespace App\Concerns\Traits\Guarantee;

use App\Enums\ConvHypothecState;
use App\Rules\Administrator\ArrayElementMatch;

trait StepsValidationRuleTrait
{
    public function validationRulesByStep($state) : array {
        $data = array(
            'documents' => 'array|required',
            'documents.*.name' => 'required|string',
            'documents.*.file' => 'required|file|max:8192|mimes:pdf,doc,docx',
        );
        switch ($state) {
            case ConvHypothecState::CREATED:
                $data = $data;
                break;
            case ConvHypothecState::PROPERTY_VERIFIED:
                $data = $data;
                break;
            case ConvHypothecState::AGREEMENT_SIGNED:
                $data = array_merge($data, [
                    'registering_date' => 'required|date|date_format:Y-m-d|before_or_equal:today',
                ]);
                break;
            case ConvHypothecState::REGISTER_REQUESTED:
                $data = array_merge($data, [
                    'is_approved' => ['required',  new ArrayElementMatch(array('yes', 'no'))],
                    'registration_date' => 'required|date|date_format:Y-m-d|before_or_equal:today',
                ]);
                break;
            case ConvHypothecState::REGISTER:
                $data = array_merge($data, [
                    'actor_type' => ['required',  new ArrayElementMatch(array('holder', 'third_party_holder'))],
                    'date_signification' => 'required|date|date_format:Y-m-d|before_or_equal:today',
                ]);
                break;
            case ConvHypothecState::SIGNIFICATION_REGISTERED:
                $data = array(
                    'is_verified' => ['required',  new ArrayElementMatch(array('yes', 'no'))],
                );
                break;

            case ConvHypothecState::ORDER_PAYMENT_VERIFIED:
                $data = array_merge($data, [
                    'visa_date' => 'required|date|date_format:Y-m-d|before_or_equal:today',
                ]);
                break;

            case ConvHypothecState::ORDER_PAYMENT_VISA:
                $data = array_merge($data, [
                    'date_deposit_specification' => 'required|date|date_format:Y-m-d|before_or_equal:today',
                    'date_sell' => 'required|date|date_format:Y-m-d|before_or_equal:today',
                ]);
                break;

            case ConvHypothecState::EXPROPRIATION:
                $data = array_merge($data, [
                    'advertisement_date' => 'required|date|date_format:Y-m-d|before_or_equal:today',
                ]);
                break;

            case ConvHypothecState::ADVERTISEMENT:
                $data = array_merge($data, [
                    'sell_price_estate' => 'required|numeric',
                ]);
                break;

            default:
                //
                break;
        }

        return $data;
    }
}
