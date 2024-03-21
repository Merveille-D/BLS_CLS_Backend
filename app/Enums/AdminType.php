<?php

namespace App\Enums;

enum AdminType: string
{
    const INDIVIDUAL = 'individual';
    const CORPORATE = 'corporate';

    const TYPES = [
        AdminType::INDIVIDUAL,
        AdminType::CORPORATE,
    ];

    const TYPES_VALUES = [
        AdminType::INDIVIDUAL => 'Personne physique',
        AdminType::CORPORATE => 'Personne morale',
    ];
}
