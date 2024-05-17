<?php

namespace App\Concerns\Traits\Litigation;

use App\Enums\ConvHypothecState;
use App\Enums\Litigation\LitigationTaskState;

trait LitigationFormFieldTrait
{
    /**
     * Get the custom form fields for each step based on the state.
     *
     * @param string $state
     * @return array
     */
    public function getCustomFormFields(string $state): array
    {
        $customFields = [];

        switch ($state) {
            case LitigationTaskState::CREATED:

                break;

            case LitigationTaskState::TRANSFER:
                $customFields = $this->commonProperties(LitigationTaskState::STATES_VALUES[LitigationTaskState::TRANSFER],
                        ['file', 'documents', 'Documents de transfert'],
                        ['date', 'completed_at', 'Date de transfert'],
                        ['text', 'firm_name', 'Nom du cabinet'],

                    );
            break;
            case LitigationTaskState::REFERRAL:
                $customFields = $this->commonProperties(LitigationTaskState::STATES_VALUES[LitigationTaskState::REFERRAL],
                        ['file', 'documents', 'Acte de saisine'],
                        ['date', 'completed_at', 'Date de saisine'],
                        ['text', 'jurisdiction', 'Juridiction saisie'],
                    );
            break;
            case LitigationTaskState::HEARING:
                $customFields = $this->commonProperties(LitigationTaskState::STATES_VALUES[LitigationTaskState::HEARING],
                        ['date', 'completed_at', 'Date de l\'audience'],
                    );
            break;
            case LitigationTaskState::REPORT:
                $customFields = $this->commonProperties(LitigationTaskState::STATES_VALUES[LitigationTaskState::REPORT],
                        ['file', 'documents', 'Rapport de l\'audience'],
                        ['date', 'completed_at', 'Date du rapport'],
                    );
            break;
            case LitigationTaskState::DECISION:
                $customFields = $this->commonProperties(LitigationTaskState::STATES_VALUES[LitigationTaskState::DECISION],
                        ['file', 'documents', 'Décision'],
                        ['date', 'completed_at', 'Date de la décision'],
                    );
            break;

            default:
                // $customFields = $this->commonProperties('Default title',  ['test', 'test', 'test']);
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
