<?php

namespace App\Enums\Watch;

enum WatchType : string
{
    const LEGISLATION = 'legislation';
    const REGULATION = 'regulation';
    const LEGAL = 'legal';

    const TYPES = [
        WatchType::LEGAL,
        WatchType::LEGISLATION,
        WatchType::REGULATION,
    ];

    const TYPES_VALUES = [
        WatchType::LEGAL => 'Judiciare',
        WatchType::LEGISLATION => 'Legislative',
        WatchType::REGULATION => 'Reglementiare',
    ];
}
