<?php
namespace App\Enums\Guarantee;

enum BondState: string{
    const CREATED = 'created';
    const REDACTION = 'redaction';
    const VERIFICATION = 'verification';
    const CREDIT_CHECK = 'credit_check';
    const COMMUNICATION = 'communication';

    const DEBTOR_FORMAL_NOTICE = 'debtor_formal_notice';
    const INFORM_GUARANTOR = 'inform_guarantor';
    const EXECUTION = 'execution';
    const GUARANTOR_FORMAL_NOTICE = 'guarantor_formal_notice';
    const GUARANTOR_PAYMENT = 'guarantor_payment';

    const STATES_VALUES = [
        BondState::CREATED => 'Initiation du cautionnement',
        BondState::REDACTION => 'Rédaction du contrat de cautionnement',
        BondState::VERIFICATION => 'Vérification du contrat de cautionnement',
        BondState::CREDIT_CHECK => 'Vérification de la solvabilité de la caution',
        BondState::COMMUNICATION => 'Communication de l\'etat des dettes',

        BondState::DEBTOR_FORMAL_NOTICE => 'Mise en demeure du débiteur principal',
        BondState::EXECUTION => 'Exécution par le débiteur',
        BondState::INFORM_GUARANTOR => 'Information la caution de la mise en demeure',
        BondState::GUARANTOR_FORMAL_NOTICE => 'Mise en demeure de la caution',
        BondState::GUARANTOR_PAYMENT => 'Paiement par la caution',
    ];
}
