<?php

namespace Database\Seeders\Guarantee;

use App\Enums\ConvHypothecState;
use App\Models\Guarantee\ConvHypothecStep;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConvHypothecSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $steps = $this->getSteps();

        foreach ($steps as $step) {
            ConvHypothecStep::create($step);
        }
    }

    function getSteps() : array {
        return [
            [
                'name' => 'Initialisation de l\'hypothèque',
                'code' => ConvHypothecState::CREATED,
                'type' => 'formalization',
                'min_delay' => null,
                'max_delay' => null,
            ],
            [
                'name' => 'Vérification propriété de l\'immeuble',
                'code' => ConvHypothecState::PROPERTY_VERIFIED,
                'type' => 'formalization',
                'min_delay' => null,
                'max_delay' => null,
            ],
            [
                'name' => 'Rédiger Convention d\'hypothèque',
                'code' => ConvHypothecState::AGREEMENT_SIGNED,
                'type' => 'formalization',
                'min_delay' => null,
                'max_delay' => null,
            ],
            [
                'name' => 'Demande d\'inscription',
                'code' => ConvHypothecState::REGISTER_REQUESTED,
                'type' => 'formalization',
                'min_delay' => null,
                'max_delay' => null,
            ],
            [
                'name' => 'Inscription',
                'code' => ConvHypothecState::REGISTER,
                'type' => 'formalization',
                'min_delay' => null,
                'max_delay' => null,
            ],

            //realizations steps
            [
                'name' => 'Signification commendement de payer',
                'code' => ConvHypothecState::SIGNIFICATION_REGISTERED,
                'type' => 'realization',
                'min_delay' => null,
                'max_delay' => null,
            ],
            [
                'name' => 'Demande D\'inscription et publication du commendement de payer
                dans  les registres de la propriété foncière',
                'code' => ConvHypothecState::ORDER_PAYMENT_VERIFIED,
                'type' => 'realization',
                'min_delay' => null,
                'max_delay' => null,
            ],
            [
                'name' => 'Saisie immobilière après visa du régisseur visa de payement',
                'code' => ConvHypothecState::ORDER_PAYMENT_VISA,
                'type' => 'realization',
                'min_delay' => 20,
                'max_delay' => 60,
            ],
            [
                'name' => 'Poursuivre l\'expropriation',
                'code' => ConvHypothecState::EXPROPRIATION,
                'type' => 'realization',
                'min_delay' => null,
                'max_delay' => null,
            ],
            [
                'name' => 'Publicité de vente',
                'code' => ConvHypothecState::ADVERTISEMENT,
                'type' => 'realization',
                'min_delay' => null,
                'max_delay' => null,
            ],
            [
                'name' => 'Vente de l\'immeuble',
                'code' => ConvHypothecState::PROPERTY_SALE,
                'type' => 'realization',
                'min_delay' => null,
                'max_delay' => null,
            ],
        ];
    }
}
