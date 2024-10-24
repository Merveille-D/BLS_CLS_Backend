<?php

namespace App\Enums\Litigation;

enum PartyCategory: string
{
    const INTERVENANT = 'intervenant';
    const DEFENDANT = 'defendant';
    const PLAINTIFF = 'plaintiff';
    const FORCED_INTERVENANT = 'forced_intervenant';

    const CATEGORIES = [
        PartyCategory::INTERVENANT,
        PartyCategory::DEFENDANT,
        PartyCategory::PLAINTIFF,
        PartyCategory::FORCED_INTERVENANT,
    ];

    const CATEGORIES_VALUES = [
        PartyCategory::INTERVENANT => 'Intervenant',
        PartyCategory::DEFENDANT => 'Défendeur',
        PartyCategory::PLAINTIFF => 'Demandeur',
        PartyCategory::FORCED_INTERVENANT => 'Intervenant forcée',
    ];
}
