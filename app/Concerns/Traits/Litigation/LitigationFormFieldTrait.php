<?php

namespace App\Concerns\Traits\Litigation;

use App\Enums\Litigation\LitigationTaskState;

trait LitigationFormFieldTrait
{
    /**
     * Get the custom form fields for each step based on the state.
     *
     * @param  string  $state
     */
    public function getCustomFormFields($step): array
    {
        $customFields = [];
        $state = $step?->code;

        switch ($state) {
            case LitigationTaskState::CREATED:

                break;

            case LitigationTaskState::TRANSFER:
                $customFields = $this->commonProperties($step->title,
                    ['file', 'documents', 'Transfer documents'],
                    ['date', 'completed_at', 'Date of transfer'],
                    // ['text', 'firm_name', 'Nom du cabinet'],

                );
                break;
            case LitigationTaskState::REFERRAL:
                $customFields = $this->commonProperties($step->title,
                    ['file', 'documents', 'Referral act'],
                    ['date', 'completed_at', 'Referral date'],
                    ['text', 'jurisdiction', 'Jurisdiction seized'],
                );
                break;
            case LitigationTaskState::HEARING:
                $customFields = $this->commonProperties($step->title,
                    ['date', 'completed_at', 'Date of the hearing'],

                );
                break;
            case LitigationTaskState::REPORT:
                $customFields = $this->commonProperties($step->title,
                    ['file', 'documents', 'Hearing report'],

                    ['date', 'completed_at', 'Date of the report'],
                );
                break;
            case LitigationTaskState::DECISION:
                $customFields = $this->commonProperties($step->title,
                    ['file', 'documents', 'Documents'],
                    ['date', 'completed_at', 'Date of the decision'],
                );
                break;

            default:
                // $customFields = $this->commonProperties('Default title',  ['test', 'test', 'test']);
                break;
        }

        return $customFields;
    }

    public function commonProperties($form_title, ...$form_fields): array
    {
        $fields = [];
        foreach ($form_fields as $key => $form_field) {
            [$type, $name, $label] = $form_field;

            $fields[] = [
                'type' => $type,
                'name' => $name,
                'label' => __('litigation.' . $label),
            ];
        }

        $customAttribute = [
            'fields' => $fields,
            'form_title' => __('litigation.' . $form_title),
        ];

        return $customAttribute;
    }
}
