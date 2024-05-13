<?php
namespace App\Enums\Guarantee;

enum BondState: string{
    const CREATED = 'created';
    const VERIFICATION = 'verification';
    const COMMUNICATION = 'communication';

    const DEBTOR_FORMAL_NOTICE = 'debtor_formal_notice';
    const INFORM_GUARANTOR = 'inform_guarantor';
    const GUARANTOR_FORMAL_NOTICE = 'guarantor_formal_notice';
    const GUARANTOR_PAYMENT = 'guarantor_payment';

    const STATES_VALUES = [
        BondState::CREATED => 'Initiation',
        BondState::VERIFICATION => 'Vérification',
        BondState::COMMUNICATION => 'Communication',

        BondState::DEBTOR_FORMAL_NOTICE => 'Mise en demeure du débiteur',
        BondState::INFORM_GUARANTOR => 'Informez le garant',
        BondState::GUARANTOR_FORMAL_NOTICE => 'Mise en demeure du garant',
        BondState::GUARANTOR_PAYMENT => 'Paiement du garant',
    ];
}
