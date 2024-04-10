<?php

namespace App\Enums\Litigation;

enum PartyType : string
{
    const CLIENT = 'client';
    const EMPLOYEE = 'employee';
    const PROVIDER = 'provider';
    const PARTNER = 'partner';
    const ARBITRATION_TRIBUNAL = 'arbitration_tribunal';

    const TYPES = [
        PartyType::CLIENT,
        PartyType::EMPLOYEE,
        PartyType::PROVIDER,
        PartyType::PARTNER,
        PartyType::ARBITRATION_TRIBUNAL,
    ];

    const TYPES_VALUES = [
        PartyType::CLIENT => 'Client',
        PartyType::EMPLOYEE => 'Employé',
        PartyType::PROVIDER => 'Fournisseur',
        PartyType::PARTNER => 'Partenaire',
        PartyType::ARBITRATION_TRIBUNAL => 'Tribunal arbitral',
    ];
}
