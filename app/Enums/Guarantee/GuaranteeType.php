<?php
namespace App\Enums\Guarantee;

enum GuaranteeType : string {
    const BONDING = 'bonding'; //cautionnement
    const AUTONOMOUS = 'autonomous'; //garantie autonome
    const AUTONOMOUS_COUNTER = 'autonomous_counter'; //contre garantie autonome
    //movable guarantee const
    const STOCK = 'stock'; //stock
    const VEHICLE = 'vehicle'; //vehicle and equipment
    //collateral guarantee const
    const SHAREHOLDER_RIGHTS = 'shareholder_rights'; //shareholder rights
    const TRADE_FUND = 'trade_fund'; //trade fund
    const BANK_ACCOUNT = 'bank_account'; //bank account


    const TYPES = [
        GuaranteeType::AUTONOMOUS,
        GuaranteeType::BONDING,
        GuaranteeType::AUTONOMOUS_COUNTER,

        GuaranteeType::STOCK,
        GuaranteeType::VEHICLE,

        GuaranteeType::SHAREHOLDER_RIGHTS,
        GuaranteeType::TRADE_FUND,
        GuaranteeType::BANK_ACCOUNT,
    ];

    const CODES = [
        GuaranteeType::AUTONOMOUS => 'GP',
        GuaranteeType::BONDING => 'GP',
        GuaranteeType::AUTONOMOUS_COUNTER => 'GP',

        GuaranteeType::STOCK => 'NA',
        GuaranteeType::VEHICLE => 'NA',

        GuaranteeType::SHAREHOLDER_RIGHTS => 'GA',
        GuaranteeType::TRADE_FUND => 'GA',
        GuaranteeType::BANK_ACCOUNT => 'GA',
    ];
}
