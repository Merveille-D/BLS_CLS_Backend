<?php
namespace App\Enums\Guarantee;

enum GuaranteeType : string {
    const BONDING = 'bonding'; //cautionnement
    const AUTONOMOUS = 'autonomous'; //garantie autonome
    const AUTONOMOUS_COUNTER = 'autonomous_counter'; //contre garantie autonome


    const TYPES = [
        GuaranteeType::AUTONOMOUS,
        GuaranteeType::BONDING,
        GuaranteeType::AUTONOMOUS_COUNTER,
    ];

    const CODES = [
        GuaranteeType::AUTONOMOUS => 'GA',
        GuaranteeType::BONDING => 'CT',
        GuaranteeType::AUTONOMOUS_COUNTER => 'CG',
    ];
}
