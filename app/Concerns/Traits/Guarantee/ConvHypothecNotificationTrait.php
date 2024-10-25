<?php

namespace App\Concerns\Traits\Guarantee;

use App\Enums\ConvHypothecState;

trait ConvHypothecNotificationTrait
{
    public function nextStepBasedOnState($state): array
    {
        $data = [
            'subject' => 'RAPPEL : Étape de ' . ConvHypothecState::STATES_VALUES[ConvHypothecState::AGREEMENT_SIGNED],
            'message' => 'Veuillez attacher les documents de la propriété pour vérification',
        ];

        switch ($state) {
            case ConvHypothecState::CREATED:
                $data = $data;
                break;
            case ConvHypothecState::PROPERTY_VERIFIED:
                $data['subject'] = 'RAPPEL : Étape de ' . ConvHypothecState::STATES_VALUES[ConvHypothecState::AGREEMENT_SIGNED];
                $data['message'] = 'Rédiger et Attacher la convention signée';
                break;
            case ConvHypothecState::AGREEMENT_SIGNED:
                $data['subject'] = 'RAPPEL : Étape de ' . ConvHypothecState::STATES_VALUES[ConvHypothecState::REGISTER_REQUESTED];
                $data['message'] = 'Joindre le document de demande d\inscription';
                break;
            case ConvHypothecState::REGISTER_REQUESTED:
                $data['subject'] = 'RAPPEL : Étape de ' . ConvHypothecState::STATES_VALUES[ConvHypothecState::REGISTER];
                $data['message'] = 'Attacher à l\'hypothèque conventionnelle la reponse de l\inscription';
                break;
            case ConvHypothecState::REGISTER:
                $data['subject'] = 'RAPPEL : Étape de ' . ConvHypothecState::STATES_VALUES[ConvHypothecState::SIGNIFICATION_REGISTERED];
                $data['message'] = 'Procéder à l\'étape de réalisation en commençant par joindre la signfication';
                break;
            case ConvHypothecState::SIGNIFICATION_REGISTERED:
                $data['subject'] = 'RAPPEL : Étape de ' . ConvHypothecState::STATES_VALUES[ConvHypothecState::ORDER_PAYMENT_VERIFIED];
                $data['message'] = 'Procéder à la vérification de l\'ordre de paiement ';
                break;

            case ConvHypothecState::ORDER_PAYMENT_VERIFIED:
                $data['subject'] = 'RAPPEL : Étape de ' . ConvHypothecState::STATES_VALUES[ConvHypothecState::ORDER_PAYMENT_VISA];
                $data['message'] = 'Procéder à la demande d\'inscription et publication du commendement de payer';
                break;

            case ConvHypothecState::ORDER_PAYMENT_VISA:
                $data['subject'] = 'RAPPEL : Étape de ' . ConvHypothecState::STATES_VALUES[ConvHypothecState::EXPROPRIATION_SPECIFICATION];
                $data['message'] = 'Procéder à l\'expropriation en attachant le cahier de charges';
                break;

            case ConvHypothecState::EXPROPRIATION_SPECIFICATION:
                $data['subject'] = 'RAPPEL : Étape de ' . ConvHypothecState::STATES_VALUES[ConvHypothecState::EXPROPRIATION_SUMMATION];
                $data['message'] = 'Procéder à l\'expropriation en adressant la sommation à prendre connaissance du cahier de charges';
                break;

            case ConvHypothecState::EXPROPRIATION_SUMMATION:
                $data['subject'] = 'RAPPEL : Étape de ' . ConvHypothecState::STATES_VALUES[ConvHypothecState::ADVERTISEMENT];
                $data['message'] = 'Procéder à la publicité de vente';
                break;

            case ConvHypothecState::ADVERTISEMENT:
                $data['subject'] = 'RAPPEL : Étape de ' . ConvHypothecState::STATES_VALUES[ConvHypothecState::PROPERTY_SALE];
                $data['message'] = 'Procéder à la vente de la propriété';
                break;

                // case ConvHypothecState::ORDER_PAYMENT_VERIFIED:
                //     $data['subject'] = 'RAPPEL : Document de la reponse d\inscription';
                //     $data['message'] = 'Attacher à l\'hypothèque conventionnelle la reponse de l\inscription';
                //     break;

                // case ConvHypothecState::ORDER_PAYMENT_VISA:
                //     $data['subject'] = 'RAPPEL : Document de la reponse d\inscription';
                //     $data['message'] = 'Attacher à l\'hypothèque conventionnelle la reponse de l\inscription';
                //     break;

                // case ConvHypothecState::EXPROPRIATION:
                //     $data['subject'] = 'RAPPEL : Document de la reponse d\inscription';
                //     $data['message'] = 'Attacher à l\'hypothèque conventionnelle la reponse de l\inscription';
                //     break;

                // case ConvHypothecState::ADVERTISEMENT:
                //     $data['subject'] = 'RAPPEL : Document de la reponse d\inscription';
                //     $data['message'] = 'Attacher à l\'hypothèque conventionnelle la reponse de l\inscription';
                //     break;

            default:
                //
                break;
        }

        return $data;
    }
}
