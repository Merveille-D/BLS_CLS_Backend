<?php

namespace App\Concerns\Traits\Recovery;

use App\Enums\Recovery\RecoveryStepEnum;

trait RecoveryFormFieldTrait
{
    public function getCustomFormFields($step) : array {
        $customFields = [];

        $status = $step?->code;

        switch ($status) {
            case RecoveryStepEnum::FORMALIZATION:
                $customFields = $this->commonProperties($step->title,  ['file', 'documents', 'Documents of the transactional act']);
                break;
            case RecoveryStepEnum::FORMAL_NOTICE:
                $customFields = $this->commonProperties($step->title,  ['file', 'documents', 'Documents of the formal notice']);
                break;
            case RecoveryStepEnum::DEBT_PAYEMENT:
                $customFields = $this->commonProperties($step->title,  ['radio', 'payement_status', 'The debtor pays his debt']);
                break;
            case RecoveryStepEnum::JURISDICTION:
                $customFields = $this->commonProperties($step->title,  ['file', 'documents', 'Documents of the procedure']);
                break;
            case RecoveryStepEnum::SEIZURE:
                $customFields = $this->commonProperties($step->title,  ['radio', 'is_seized', 'Seizure of the competent jurisdiction']);
                break;
            case RecoveryStepEnum::EXECUTORY:
                $customFields = $this->commonProperties($step->title,  ['file', 'documents', 'Enforceable title']);
                break;
            case RecoveryStepEnum::ENTRUST_LAWYER:
                $customFields = $this->commonProperties($step->title,  ['radio', 'is_entrusted', 'The procedure has been entrusted']);
                break;

            default:
                # code...
                break;
        }

        return $customFields;
    }


    public function commonProperties($form_title, ...$form_fields) : array {
        $fields =  [] ;
        foreach ($form_fields as $key => $form_field) {
            list($type, $name, $label) = $form_field;

            $fields[] = [
                "type" => $type,
                "name" => $name,
                "label" => __('recovery.'.$label)
            ];
        }

        $customAttribute = [
            "fields" => $fields,
            "form_title" => __('recovery.'.$form_title)
        ];

        return $customAttribute;
    }
}
