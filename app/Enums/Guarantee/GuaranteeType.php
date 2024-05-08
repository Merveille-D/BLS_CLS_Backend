<?php
namespace App\Enums\Guarantee;

enum GuaranteeType : string {
    const GUARANTEE_BOND = 'guarantee_bond'; //cautionnement
    const AUTONOMOUS_GUARANTEE = 'autonomous_guarantee';
    const AUTONOMOUS_COUNTER_GUARANTEE = 'autonomous_counter-guarantee';


    const TYPES = [
        GuaranteeType::AUTONOMOUS_GUARANTEE,
        GuaranteeType::GUARANTEE_BOND,
        GuaranteeType::AUTONOMOUS_COUNTER_GUARANTEE,
    ];
}
