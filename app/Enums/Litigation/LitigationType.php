<?php

namespace App\Enums\Litigation;

enum LitigationType : string
{
    const JURISDICTION = 'jurisdiction';
    const NATURE = 'nature';

    const TYPES = [
        LitigationType::JURISDICTION,
        LitigationType::NATURE,
    ];

    const TYPES_VALUES = [
        LitigationType::JURISDICTION => 'Juridiction',
        LitigationType::NATURE => 'Nature',
    ];
}
