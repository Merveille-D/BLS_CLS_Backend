<?php
namespace App\Enums\Litigation;

use App\Models\Transfer\Transfer;

enum LitigationTaskState : string
{
    const CREATED = 'created';
    const TRANSFER = 'transfer';
    const REFERRAL = 'referral';
    const HEARING = 'hearing';
    const REPORT = 'report';
    const DECISION = 'decision';

    const STATES = [
        LitigationTaskState::CREATED,
        LitigationTaskState::TRANSFER,
        LitigationTaskState::REFERRAL,
        LitigationTaskState::HEARING,
        LitigationTaskState::REPORT,
        LitigationTaskState::DECISION,
    ];

    const STATES_VALUES = [
        LitigationTaskState::CREATED => 'Créé',
        LitigationTaskState::TRANSFER => 'Transfert',
        LitigationTaskState::REFERRAL => 'Saisine de la juridiction',
        LitigationTaskState::HEARING => 'Première audience',
        LitigationTaskState::REPORT => 'Rapport',
        LitigationTaskState::DECISION => 'Décision',
    ];

}
