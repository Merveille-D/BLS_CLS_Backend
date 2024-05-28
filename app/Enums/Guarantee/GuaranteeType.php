<?php
namespace App\Enums\Guarantee;

enum GuaranteeType : string {
    const MORTGAGE = 'mortgage'; //hypothèque

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
        GuaranteeType::MORTGAGE,

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
        GuaranteeType::MORTGAGE => 'HC',

        GuaranteeType::AUTONOMOUS => 'GP',
        GuaranteeType::BONDING => 'GP',
        GuaranteeType::AUTONOMOUS_COUNTER => 'GP',

        GuaranteeType::STOCK => 'NA',
        GuaranteeType::VEHICLE => 'NA',

        GuaranteeType::SHAREHOLDER_RIGHTS => 'GA',
        GuaranteeType::TRADE_FUND => 'GA',
        GuaranteeType::BANK_ACCOUNT => 'GA',
    ];

    const VALUES = [
        GuaranteeType::MORTGAGE => 'Hypothèque conventionnelle',

        GuaranteeType::AUTONOMOUS => 'Garantie autonome',
        GuaranteeType::BONDING => 'Garantie de cautionnement',
        GuaranteeType::AUTONOMOUS_COUNTER => 'Contre garantie autonome',

        GuaranteeType::STOCK => 'Gage de stock',
        GuaranteeType::VEHICLE => 'Gage de véhicule ...',

        GuaranteeType::SHAREHOLDER_RIGHTS => 'Nantissement de droits d\'associés, les valeurs mobilières ...',
        GuaranteeType::TRADE_FUND => 'Nantissement de fonds de commerce',
        GuaranteeType::BANK_ACCOUNT => 'Nantissement de créances/compte bancaire',
    ];
}
