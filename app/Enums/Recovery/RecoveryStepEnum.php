<?php

namespace App\Enums\Recovery;

enum RecoveryStepEnum: string
{
    const CREATED = 'created';
    const FORMALIZATION = 'formalization';

    const FORMAL_NOTICE = 'formal_notice';
    const DEBT_PAYEMENT = 'debt_payement';
    const JURISDICTION = 'jurisdiction';
    const SEIZURE = 'seizure';
    const EXECUTORY = 'executory';
    const ENTRUST_LAWYER = 'entrust_lawyer';
}
