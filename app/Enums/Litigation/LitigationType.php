<?php

namespace App\Enums\Litigation;

enum LitigationType : string
{
    const JURISDICTION = 'jurisdiction';
    const NATURE = 'nature';
    const QUALITY = 'quality';
    const PARTY_TYPE = 'party_type';
    const DOCUMENT = 'document';

    const TYPES = [
        LitigationType::JURISDICTION,
        LitigationType::NATURE,
        LitigationType::DOCUMENT,
        LitigationType::QUALITY,
        LitigationType::PARTY_TYPE,
    ];

    const TYPES_VALUES = [
        LitigationType::JURISDICTION => 'Juridiction',
        LitigationType::NATURE => 'Nature',
        LitigationType::DOCUMENT => 'Document',
    ];
}
