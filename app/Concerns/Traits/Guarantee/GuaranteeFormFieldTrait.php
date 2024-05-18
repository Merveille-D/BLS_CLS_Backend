<?php

namespace App\Concerns\Traits\Guarantee;

use App\Enums\Guarantee\AutonomousCounterState;
use App\Enums\Guarantee\AutonomousState;
use App\Enums\Guarantee\BondState;
use App\Enums\Guarantee\GuaranteeType;
use App\Enums\Guarantee\StockState;

trait GuaranteeFormFieldTrait
{

    public function loadFormAttributeBasedOnType($guarantee) {

        switch ($guarantee->type) {
            case GuaranteeType::BONDING:
                return $this->bondFormFields($this->code);
                break;
            case GuaranteeType::AUTONOMOUS:
                return $this->autonomousFormFields($this->code);
                break;

            case GuaranteeType::AUTONOMOUS_COUNTER:
                return $this->counterAutonomousFormFields($this->code);
                break;

            case GuaranteeType::STOCK:
                return $this->stockFormFields($this->code);
            break;

            default:
                # code...
                break;
        }
    }

    /**
     * Get the custom form fields for each step based on the state.
     *
     * @param string $state
     * @return array
     */
    public function bondFormFields(string $state): array
    {
        $formFields = [];

        switch ($state) {
            case BondState::CREATED:

            break;
            case BondState::REDACTION:
                $formFields = $this->commonProperties(BondState::STATES_VALUES[BondState::REDACTION],
                        ['file', 'documents', 'Documents du contrat de cautionnement'],
                        ['date', 'completed_at', 'Date du contrat'],
                    );
            break;
            case BondState::VERIFICATION:

            break;
            case BondState::COMMUNICATION:
                $formFields = $this->commonProperties(BondState::STATES_VALUES[BondState::COMMUNICATION],
                        ['file', 'documents', 'Documents de la communication'],
                        ['date', 'completed_at', 'Date de la communication'],
                    );
            break;
            case BondState::DEBTOR_FORMAL_NOTICE:
                $formFields = $this->commonProperties(BondState::STATES_VALUES[BondState::DEBTOR_FORMAL_NOTICE],
                        ['file', 'documents', 'Documents de la mise en demeure'],
                        ['date', 'completed_at', 'Date de la mise en demeure'],
                    );
            break;
            case BondState::EXECUTION:
                $formFields = $this->commonProperties(BondState::STATES_VALUES[BondState::EXECUTION],
                        ['radio', 'is_executed', 'Exécution par le debiteur'],
                        // ['date', 'completed_at', 'Date de l\'exécution'],
                    );
            break;
            case BondState::INFORM_GUARANTOR:

            break;
            case BondState::GUARANTOR_FORMAL_NOTICE:
                $formFields = $this->commonProperties(BondState::STATES_VALUES[BondState::GUARANTOR_FORMAL_NOTICE],
                        ['file', 'documents', 'Documents de la mise en demeure'],
                        ['date', 'completed_at', 'Date de la mise en demeure'],
                    );
            break;
            case BondState::GUARANTOR_PAYMENT:
                $formFields = $this->commonProperties(BondState::STATES_VALUES[BondState::GUARANTOR_PAYMENT],
                        ['radio', 'is_paid', 'Paiement par la caution'],
                        ['date', 'completed_at', 'Date du paiement'],
                    );
            break;

            default:
                // do not display any form fields
                break;
        }

        return $formFields;
    }

    /**
     * Provide form fields for each autonomous guarantee state
     *
     * @param  mixed $state
     * @return array
     */
    public function autonomousFormFields(string $state) : array {
        $form_fields = [];

        switch ($state) {

            case AutonomousState::REDACTION:
                $form_fields = $this->commonProperties(AutonomousState::STATES_VALUES[AutonomousState::REDACTION],
                    ['file', 'documents', 'Documents du contrat'],
                    ['date', 'completed_at', 'Date redaction du contrat'],
                );
            break;
            case AutonomousState::VERIFICATION:

            break;
            case AutonomousState::SIGNATURE:
                $form_fields = $this->commonProperties(AutonomousState::STATES_VALUES[AutonomousState::SIGNATURE],
                    ['select', 'contract_type', 'Choisir la durée du contrat'],
                );
            break;

            case AutonomousState::PAYEMENT_REQUEST:
                $form_fields = $this->commonProperties(AutonomousState::STATES_VALUES[AutonomousState::PAYEMENT_REQUEST],
                    ['file', 'documents', 'Documents de la demande de paiement'],
                    ['date', 'completed_at', 'Date de la demande'],
                );
            break;
            case AutonomousState::REQUEST_VERIFICATION:
                $form_fields = $this->commonProperties(AutonomousState::STATES_VALUES[AutonomousState::REQUEST_VERIFICATION],
                    ['radio', 'is_paid', 'Paiement par le garant'],
                    ['date', 'completed_at', 'Date de la vérification'],
                );
            break;

            default:
                // do not display any form fields
                break;
        }

        return $form_fields;
    }


    /**
     * provide form fields for each counter autonomous state
     *
     * @param  string $state
     * @return array
     */
    public function counterAutonomousFormFields(string $state) : array {
        $form_fields = [];

        switch ($state) {
            case AutonomousState::REDACTION:
                $form_fields = $this->commonProperties(AutonomousState::STATES_VALUES[AutonomousState::REDACTION],
                    ['file', 'documents', 'Documents du contrat'],
                    ['date', 'completed_at', 'Date redaction du contrat'],
                );
            break;

            case AutonomousCounterState::VERIFICATION:

            break;

            case AutonomousCounterState::SIGNATURE:
                $form_fields = $this->commonProperties(AutonomousState::STATES_VALUES[AutonomousState::SIGNATURE],
                    ['select', 'contract_type', 'Choisir la durée du contrat'],
                );
                break;

            case AutonomousCounterState::GUARANTOR_PAYEMENT_REQUEST:
                $form_fields = $this->commonProperties(AutonomousCounterState::STATES_VALUES[AutonomousCounterState::GUARANTOR_PAYEMENT_REQUEST],
                    ['file', 'documents', 'Documents de la demande de paiement'],
                    ['date', 'completed_at', 'Date de la demande'],
                );
                break;
            case AutonomousCounterState::COUNTER_GUARD_REQUEST:
                $form_fields = $this->commonProperties(AutonomousCounterState::STATES_VALUES[AutonomousCounterState::COUNTER_GUARD_REQUEST],
                    ['file', 'documents', 'Documents de la demande de paiement'],
                    ['date', 'completed_at', 'Date de la demande'],
                );
                break;

            case AutonomousCounterState::REQUEST_VERIFICATION:
                $form_fields = $this->commonProperties(AutonomousState::STATES_VALUES[AutonomousState::REQUEST_VERIFICATION],
                    ['radio', 'is_paid', 'Paiement par le contre garant'],
                    ['date', 'completed_at', 'Date de la vérification'],
                );
                break;

            default:
                # code...
                break;
        }

        return $form_fields;
    }

    /**
     * Provide form fields for each stock guarantee state
     *
     * @param  string $state
     * @return array
     */

    public function stockFormFields(string $state) : array {
        $form_fields = [];

        switch ($state) {
            case StockState::REDACTION:
                $form_fields = $this->commonProperties(StockState::STATES_VALUES[StockState::REDACTION],
                    ['file', 'documents', 'Documents du contrat'],
                    ['date', 'completed_at', 'Date redaction du contrat'],
                );
            break;
            case StockState::NOTARY_DEPOSIT:
                $form_fields = $this->commonProperties(StockState::STATES_VALUES[StockState::NOTARY_DEPOSIT],
                    ['file', 'documents', 'Documents du contrat'],
                    ['date', 'completed_at', 'Date redaction du contrat'],
                );
            break;
            case StockState::NOTARY_TRANSMISSION:
                $form_fields = $this->commonProperties(StockState::STATES_VALUES[StockState::NOTARY_TRANSMISSION],
                    ['file', 'documents', 'Documents du contrat'],
                    ['date', 'completed_at', 'Date redaction du contrat'],
                );
            break;
            case StockState::CONVENTION_OBTENTION:
                $form_fields = $this->commonProperties(StockState::STATES_VALUES[StockState::CONVENTION_OBTENTION],
                    ['file', 'documents', 'Documents du contrat'],
                    ['date', 'completed_at', 'Date redaction du contrat'],
                );
            break;
            case StockState::RCCM_REGISTRATION:
                $form_fields = $this->commonProperties(StockState::STATES_VALUES[StockState::RCCM_REGISTRATION],
                    ['file', 'documents', 'Documents du contrat'],
                    ['date', 'completed_at', 'Date redaction du contrat'],
                );
            break;
            case StockState::RCCM_PROOF:
                $form_fields = $this->commonProperties(StockState::STATES_VALUES[StockState::RCCM_PROOF],
                    ['file', 'documents', 'Documents du contrat'],
                    ['date', 'completed_at', 'Date redaction du contrat'],
                );
            break;
            case StockState::GUARANTEE_OBTENTION:
                $form_fields = $this->commonProperties(StockState::STATES_VALUES[StockState::GUARANTEE_OBTENTION],
                    ['file', 'documents', 'Documents du contrat'],
                    ['date', 'completed_at', 'Date redaction du contrat'],
                );
            break;
            case StockState::HUISSIER_NOTIFICATION:
                $form_fields = $this->commonProperties(StockState::STATES_VALUES[StockState::HUISSIER_NOTIFICATION],
                    ['file', 'documents', 'Documents du contrat'],
                    ['date', 'completed_at', 'Date redaction du contrat'],
                );
            break;
            case StockState::DOMICILIATION_OBTENTION:
                $form_fields = $this->commonProperties(StockState::STATES_VALUES[StockState::DOMICILIATION_OBTENTION],
                    ['file', 'documents', 'Documents du contrat'],
                    ['date', 'completed_at', 'Date redaction du contrat'],
                );
            break;

            default:
                // do not display any form fields
                break;
        }

        return $form_fields;
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
