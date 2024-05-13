<?php
namespace App\Enums\Guarantee;

enum AutonomousState: string{
    const CREATED = 'created';
    const VERIFICATION = 'verification';
    const SIGNATURE = 'signature';

    const PAYEMENT_REQUEST = 'payement_request';
    const REQUEST_VERIFICATION = 'request_verification';


    const STATES_VALUES = [
        AutonomousState::CREATED => 'Initiation de la garantie',
        AutonomousState::VERIFICATION => 'Vérification de la validité du contrat',
        AutonomousState::SIGNATURE => 'SIGNATURE DU CONTRAT DE GARANTIE AUTONOME',
        AutonomousState::PAYEMENT_REQUEST => 'DEMANDE DE PAIEMENT ADRESSE AU GARANT',
        AutonomousState::REQUEST_VERIFICATION => 'VERIFICATION DE LA DEMANDE PAR LE GARANT',

    ];
}
