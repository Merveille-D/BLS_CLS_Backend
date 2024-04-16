<?php
namespace App\Enums;

enum ConvHypothecState {
    const CREATED = 'created';
    const PROPERTY_VERIFIED = 'property_verified';
    const AGREEMENT_SIGNED = 'agreement_signed';
    const REGISTER_REQUESTED = 'register_requested';
    const REGISTER = 'registered';
    const NONREGISTER = 'non_registered';

    const SIGNIFICATION_REGISTERED = 'signification_registered';
    const ORDER_PAYMENT_VERIFIED = 'order_payment_verified';
    const ORDER_PAYMENT_VISA = 'order_payment_visa';
    const EXPROPRIATION_SPECIFICATION = 'expropriation-specification';
    // const EXPROPRIATION_SALE = 'expropriation-sale';
    const EXPROPRIATION_SUMMATION = 'expropriation-summation';
    const ADVERTISEMENT = 'advertisement';
    const PROPERTY_SALE = 'property_sale';

    const STATES = [
        ConvHypothecState::CREATED,
        ConvHypothecState::PROPERTY_VERIFIED,
    ];

    const STATES_VALUES = [
        ConvHypothecState::CREATED => 'Création nouvelle hypothèque',
        ConvHypothecState::PROPERTY_VERIFIED => 'Vérification propriété de l\'hypothèque',
        ConvHypothecState::AGREEMENT_SIGNED => 'Convention signée',
        ConvHypothecState::REGISTER_REQUESTED => 'Demande d\'inscription',
        ConvHypothecState::REGISTER => 'Réponse de l\'inscription',
        ConvHypothecState::SIGNIFICATION_REGISTERED => 'Demande de signification',
        ConvHypothecState::ORDER_PAYMENT_VERIFIED => 'Ordre de payement',
        ConvHypothecState::ORDER_PAYMENT_VISA => 'visa de payement',
        ConvHypothecState::EXPROPRIATION_SPECIFICATION => 'Expropriation : Dépôt de cahier de charges',
        // ConvHypothecState::EXPROPRIATION_SALE => 'Expropriation : Fixation de la date de vente',
        ConvHypothecState::EXPROPRIATION_SUMMATION => 'Expropriation : Adresser Sommation à prendre connaissance du cahier de charges',
        ConvHypothecState::ADVERTISEMENT => 'Publicité de vente',
        ConvHypothecState::PROPERTY_SALE => 'Vente de la propriété',
    ];
}
