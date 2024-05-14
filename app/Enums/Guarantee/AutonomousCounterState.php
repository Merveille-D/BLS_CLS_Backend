<?php
namespace App\Enums\Guarantee;

enum AutonomousCounterState: string{
    const CREATED = 'created';
    const REDACTION = 'redaction';
    const VERIFICATION = 'verification';
    const SIGNATURE = 'signature';

    const GUARANTOR_PAYEMENT_REQUEST = 'guarantor_payement_request';
    const COUNTER_GUARD_REQUEST = 'counter_guard_request';
    const REQUEST_VERIFICATION = 'request_verification';

    const STATES_VALUES = [
        AutonomousCounterState::CREATED => 'Initiation de la contre garantie',
        AutonomousCounterState::REDACTION => 'Rédaction du contrat de contre garantie autonome',
        AutonomousCounterState::VERIFICATION => 'Vérification de la validité du contrat',
        AutonomousCounterState::SIGNATURE => 'SIGNATURE DU CONTRAT DE GARANTIE AUTONOME',
        AutonomousCounterState::GUARANTOR_PAYEMENT_REQUEST => 'DEMANDE DE PAIEMENT ADRESSE AU GARANT',
        AutonomousCounterState::COUNTER_GUARD_REQUEST => 'DEMANDE DE PAIEMENT ADRESSE AU CONTRE GARANT',
        AutonomousCounterState::REQUEST_VERIFICATION => 'VERIFICATION DE LA DEMANDE PAR LE CONTRE GARANT',

    ];
}
