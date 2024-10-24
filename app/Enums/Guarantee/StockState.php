<?php

namespace App\Enums\Guarantee;

/**
 * StockState enum class.
 */
enum StockState: string
{
    const CREATED = 'created';
    const REDACTION = 'redaction';
    const NOTARY_DEPOSIT = 'notary_deposit';
    const NOTARY_TRANSMISSION = 'notary_transmission';
    const CONVENTION_OBTENTION = 'convention_obtention';
    const RCCM_REGISTRATION = 'rccm_registration';
    const RCCM_PROOF = 'rccm_proof';
    const GUARANTEE_OBTENTION = 'guarantee_obtention';
    const HUISSIER_NOTIFICATION = 'huissier_notification';
    const DOMICILIATION_OBTENTION = 'domiciliation_obtention';

    const STATES_VALUES = [
        StockState::CREATED => 'Initiation de la garantie',
        StockState::REDACTION => 'Rédaction de la convention de gage',
        StockState::NOTARY_DEPOSIT => 'Dépot de la convention au rang des minutes d\'un notaire',
        StockState::NOTARY_TRANSMISSION => 'Transmission au notaire d\'une demande d\'incription de la garantie au RCCM',
        StockState::CONVENTION_OBTENTION => 'Obtention de la convention de garantie enregistrée',
        StockState::RCCM_REGISTRATION => 'Envoi d\'une demande par le notaire au RCCM pour enregistrement de la garantie',
        StockState::RCCM_PROOF => 'Obtention de la preuve d\'enregistrement de la garantie au RCCM',
        StockState::GUARANTEE_OBTENTION => 'Obtention de la garantie enregistrée',
        StockState::HUISSIER_NOTIFICATION => 'Notification de l\'huissier pour signification de la garantie',
        StockState::DOMICILIATION_OBTENTION => 'Obtention de la domiciliation bancaire',
    ];

}
