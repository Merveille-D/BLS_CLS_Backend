<?php

namespace App\Enums\Litigation;

enum LitigationType : string
{
    const JURISDICTION = 'jurisdiction';
    const NATURE = 'nature';
    const DOCUMENT = 'document';

    const TYPES = [
        LitigationType::JURISDICTION,
        LitigationType::NATURE,
        LitigationType::DOCUMENT,
    ];

    const TYPES_VALUES = [
        LitigationType::JURISDICTION => 'Juridiction',
        LitigationType::NATURE => 'Nature',
        LitigationType::DOCUMENT => 'Document',
    ];
}
