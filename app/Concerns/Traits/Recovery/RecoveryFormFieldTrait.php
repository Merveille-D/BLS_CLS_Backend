<?php

namespace App\Concerns\Traits\Recovery;

use App\Enums\Recovery\RecoveryStepEnum;

trait RecoveryFormFieldTrait
{
    public function getCustomFormFields(string $status) : array {
        $customFields = [];

        switch ($status) {
            case RecoveryStepEnum::FORMALIZATION:
                $customFields = $this->commonProperties('Attacher l\'acte transactionnel formalisé',  ['file', 'documents', 'documents de l\'acte transactionnel']);
                break;
            case RecoveryStepEnum::FORMAL_NOTICE:
                $customFields = $this->commonProperties('Insérer document de la mise en demeure',  ['file', 'documents', 'documents de la mise en demeure']);
                break;
            case RecoveryStepEnum::DEBT_PAYEMENT:
                $customFields = $this->commonProperties('Le débiteur paie sa dette',  ['radio', 'payement_status', 'Le débiteur paie sa dette']);
                break;
            case RecoveryStepEnum::JURISDICTION:
                $customFields = $this->commonProperties('Initier une procédure de saisie des biens du débiteur',  ['file', 'documents', 'documents de la procédure']);
                break;
            case RecoveryStepEnum::SEIZURE:
                $customFields = $this->commonProperties('Saisie de la juridiction compétente',  ['radio', 'is_seized', 'Saisie de la juridiction compétente']);
                break;
            case RecoveryStepEnum::EXECUTORY:
                $customFields = $this->commonProperties('Attacher le titre exécutoire',  ['file', 'documents', 'Titre exécutoire']);
                break;
            case RecoveryStepEnum::ENTRUST_LAWYER:
                $customFields = $this->commonProperties('Confier la procédure à un avocat',  ['radio', 'is_entrusted', 'La procédure a bien été confiée']);
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
                "label" => $label,
            ];
        }

        $customAttribute = [
            "fields" => $fields,
            "form_title" => $form_title
        ];

        return $customAttribute;
    }
}
