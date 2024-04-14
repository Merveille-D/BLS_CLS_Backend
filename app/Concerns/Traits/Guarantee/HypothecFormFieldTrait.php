<?php

namespace App\Concerns\Traits\Guarantee;

use App\Enums\ConvHypothecState;

trait HypothecFormFieldTrait
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
            case ConvHypothecState::CREATED:
                $customFields = $this->commonProperties('Attacher propriété de l\'immeuble',  ['file', 'documents', 'documents de la propriété']);
                break;
            case ConvHypothecState::PROPERTY_VERIFIED:
                $customFields = $this->commonProperties(ConvHypothecState::STATES_VALUES[ConvHypothecState::AGREEMENT_SIGNED],
                        ['file', 'documents', 'Documents de la convention signée'],
                        // ['date', 'registering_date', 'Date signature convention'],
                    );
                break;

            case ConvHypothecState::AGREEMENT_SIGNED:
                $customFields = $this->commonProperties(ConvHypothecState::STATES_VALUES[ConvHypothecState::REGISTER_REQUESTED],
                    ['file', 'documents', 'Inserer la décharge'],
                    ['date', 'registering_date', 'Date d\'envoi de la demande'],

                );
                break;
            case ConvHypothecState::REGISTER_REQUESTED:
                $customFields = $this->commonProperties(ConvHypothecState::STATES_VALUES[ConvHypothecState::REGISTER],
                    ['file', 'documents', 'Inserer la preuve de l\'inscription'],
                    ['text', 'is_approved', 'L\'inscription est elle approuvée'],
                    ['date', 'registration_date', 'Insérer preuve'],

                );
                break;

            case ConvHypothecState::REGISTER:
                $customFields = $this->commonProperties(ConvHypothecState::STATES_VALUES[ConvHypothecState::SIGNIFICATION_REGISTERED],
                    ['file', 'documents', 'Inserer la preuve de l\'inscription'],
                    ['text', 'actor_type', 'Type d\'acteur'],
                    ['date', 'date_signification', 'Date de la signification'],

                );
                break;
            case ConvHypothecState::SIGNIFICATION_REGISTERED:
                $customFields = $this->commonProperties(ConvHypothecState::STATES_VALUES[ConvHypothecState::ORDER_PAYMENT_VERIFIED],
                    ['text', 'is_verified', 'Vérification'],

                );
                break;
            case ConvHypothecState::ORDER_PAYMENT_VERIFIED:
                $customFields = $this->commonProperties(ConvHypothecState::STATES_VALUES[ConvHypothecState::ORDER_PAYMENT_VISA],
                    ['file', 'documents', 'INSERER COMMENDEMENT DE PAYER VISE'],
                    ['text', 'is_verified', 'Vérification'],
                    ['date', 'visa_date', 'Date du visa'],

                );
                break;
            case ConvHypothecState::ORDER_PAYMENT_VISA:
                $customFields = $this->commonProperties(ConvHypothecState::STATES_VALUES[ConvHypothecState::EXPROPRIATION],
                    ['file', 'documents', 'INSERER COPIE DU CAHIER DE CHARGES'],
                    ['date', 'date_deposit_specification', 'Date de dépôt du cahier de charges'],
                    ['date', 'date_sell', 'Date du visa'],

                );
                break;
            case ConvHypothecState::EXPROPRIATION:
                $customFields = $this->commonProperties(ConvHypothecState::STATES_VALUES[ConvHypothecState::ADVERTISEMENT],
                    ['file', 'documents', 'Insérer copie de la publicité'],
                    ['date', 'advertisement_date', 'Date du visa'],

                );
                break;
            case ConvHypothecState::ADVERTISEMENT:
                $customFields = $this->commonProperties(ConvHypothecState::STATES_VALUES[ConvHypothecState::ADVERTISEMENT],
                    ['file', 'documents', 'INSERER COMMENDEMENT DE PAYER VISE'],
                    ['number', 'sell_price_estate', 'Montant de vente'],

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
