<?php

namespace App\Concerns\Traits\Guarantee;

use App\Enums\Guarantee\AutonomousCounterState;
use App\Enums\Guarantee\AutonomousState;
use App\Enums\Guarantee\BondState;
use App\Enums\Guarantee\GuaranteeType;

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
            case BondState::VERIFICATION:
                $formFields = $this->commonProperties(BondState::STATES_VALUES[BondState::VERIFICATION],
                        ['file', 'documents', 'Documents de la convention signée'],
                        // ['date', 'date', 'Date signature convention'],
                    );
            break;
            case BondState::COMMUNICATION:
                $formFields = $this->commonProperties(BondState::STATES_VALUES[BondState::COMMUNICATION],
                        ['file', 'documents', 'Documents de la convention signée'],
                        // ['date', 'registering_date', 'Date signature convention'],
                    );
            break;
            case BondState::DEBTOR_FORMAL_NOTICE:
                $formFields = $this->commonProperties(BondState::STATES_VALUES[BondState::DEBTOR_FORMAL_NOTICE],
                        ['file', 'documents', 'Documents de la convention signée'],
                        // ['date', 'registering_date', 'Date signature convention'],
                    );
            break;
            case BondState::INFORM_GUARANTOR:
                $formFields = $this->commonProperties(BondState::STATES_VALUES[BondState::INFORM_GUARANTOR],
                        ['file', 'documents', 'Documents de la convention signée'],
                        // ['date', 'registering_date', 'Date signature convention'],
                    );
            break;
            case BondState::GUARANTOR_FORMAL_NOTICE:
                $formFields = $this->commonProperties(BondState::STATES_VALUES[BondState::GUARANTOR_FORMAL_NOTICE],
                        ['file', 'documents', 'Documents de la convention signée'],
                        // ['date', 'registering_date', 'Date signature convention'],
                    );
            break;
            case BondState::GUARANTOR_PAYMENT:
                $formFields = $this->commonProperties(BondState::STATES_VALUES[BondState::GUARANTOR_PAYMENT],
                        ['file', 'documents', 'Documents de la convention signée'],
                        // ['date', 'registering_date', 'Date signature convention'],
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
            case AutonomousState::CREATED:
                $form_fields = $this->commonProperties(AutonomousState::STATES_VALUES[AutonomousState::CREATED],
                    ['file', 'documents', 'Documents de la convention signée'],
                    // ['date', 'registering_date', 'Date signature convention'],
                );
            break;
            case AutonomousState::VERIFICATION:
                $form_fields = $this->commonProperties(AutonomousState::STATES_VALUES[AutonomousState::VERIFICATION],
                    ['file', 'documents', 'Documents de la convention signée'],
                    // ['date', 'registering_date', 'Date signature convention'],
                );
            break;
            case AutonomousState::SIGNATURE:
                $form_fields = $this->commonProperties(AutonomousState::STATES_VALUES[AutonomousState::SIGNATURE],
                    ['file', 'documents', 'Documents de la convention signée'],
                    // ['date', 'registering_date', 'Date signature convention'],
                );
            break;

            case AutonomousState::PAYEMENT_REQUEST:
                $form_fields = $this->commonProperties(AutonomousState::STATES_VALUES[AutonomousState::PAYEMENT_REQUEST],
                    ['file', 'documents', 'Documents de la convention signée'],
                    // ['date', 'registering_date', 'Date signature convention'],
                );
            break;
            case AutonomousState::REQUEST_VERIFICATION:
                $form_fields = $this->commonProperties(AutonomousState::STATES_VALUES[AutonomousState::REQUEST_VERIFICATION],
                    ['file', 'documents', 'Documents de la convention signée'],
                    // ['date', 'registering_date', 'Date signature convention'],
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
            case AutonomousCounterState::CREATED:
                $form_fields = $this->commonProperties(AutonomousCounterState::STATES_VALUES[AutonomousCounterState::CREATED],
                    ['file', 'documents', 'Documents de la convention signée'],
                    // ['date', 'registering_date', 'Date signature convention'],
                );
                break;

            case AutonomousCounterState::VERIFICATION:
                $form_fields = $this->commonProperties(AutonomousCounterState::STATES_VALUES[AutonomousCounterState::VERIFICATION],
                    ['file', 'documents', 'Documents de la convention signée'],
                    // ['date', 'registering_date', 'Date signature convention'],
                );
                break;

            case AutonomousCounterState::SIGNATURE:
                $form_fields = $this->commonProperties(AutonomousCounterState::STATES_VALUES[AutonomousCounterState::SIGNATURE],
                    ['file', 'documents', 'Documents de la convention signée'],
                    // ['date', 'registering_date', 'Date signature convention'],
                );
                break;

            case AutonomousCounterState::GUARANTOR_PAYEMENT_REQUEST:
                $form_fields = $this->commonProperties(AutonomousCounterState::STATES_VALUES[AutonomousCounterState::GUARANTOR_PAYEMENT_REQUEST],
                    ['file', 'documents', 'Documents de la convention signée'],
                    // ['date', 'registering_date', 'Date signature convention'],
                );
                break;
            case AutonomousCounterState::COUNTER_GUARD_REQUEST:
                $form_fields = $this->commonProperties(AutonomousCounterState::STATES_VALUES[AutonomousCounterState::COUNTER_GUARD_REQUEST],
                    ['file', 'documents', 'Documents de la convention signée'],
                    // ['date', 'registering_date', 'Date signature convention'],
                );
                break;

            case AutonomousCounterState::REQUEST_VERIFICATION:
                $form_fields = $this->commonProperties(AutonomousCounterState::STATES_VALUES[AutonomousCounterState::REQUEST_VERIFICATION],
                    ['file', 'documents', 'Documents de la convention signée'],
                    // ['date', 'registering_date', 'Date signature convention'],
                );
                break;

            default:
                # code...
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
