<?php

namespace Database\Seeders\Guarantee;

use App\Enums\ConvHypothecState;
use App\Models\Guarantee\ConvHypothec;
use App\Models\Guarantee\ConvHypothecStep;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
                'name' => 'Initiation de l\'hypothèque',
                'code' => ConvHypothecState::CREATED,
                'type' => 'formalization',
                'rank' => 1,
                'min_delay' => null,
                'max_delay' => null,
            ],
            [
                'name' => 'Vérification propriété de l\'immeuble',
                'code' => ConvHypothecState::PROPERTY_VERIFIED,
                'type' => 'formalization',
                'rank' => 2,
                'min_delay' => null,
                'max_delay' => null,
            ],
            [
                'name' => 'Rédiger Convention d\'hypothèque',
                'code' => ConvHypothecState::AGREEMENT_SIGNED,
                'type' => 'formalization',
                'rank' => 3,
                'min_delay' => null,
                'max_delay' => null,
            ],
            [
                'name' => 'Demande d\'inscription',
                'code' => ConvHypothecState::REGISTER_REQUESTED,
                'type' => 'formalization',
                'rank' => 4,
                'min_delay' => null,
                'max_delay' => null,
            ],
            [
                'name' => 'Inscription',
                'code' => ConvHypothecState::REGISTER,
                'type' => 'formalization',
                'rank' => 5,
                'min_delay' => null,
                'max_delay' => 8,
            ],

            //realizations steps
            [
                'name' => 'Signification commendement de payer',
                'code' => ConvHypothecState::SIGNIFICATION_REGISTERED,
                'type' => 'realization',
                'rank' => 1,
                'min_delay' => null,
                'max_delay' => null,
            ],
            [
                'name' => 'Demande D\'inscription et publication du commendement de payer dans  les registres de la propriété foncière',
                'code' => ConvHypothecState::ORDER_PAYMENT_VERIFIED,
                'type' => 'realization',
                'rank' => 2,
                'min_delay' => 20,
                'max_delay' => 90,
            ],
            [
                'name' => 'Saisie immobilière après visa du régisseur sur le commendement de payer',
                'code' => ConvHypothecState::ORDER_PAYMENT_VISA,
                'type' => 'realization',
                'rank' => 3,
                'min_delay' => null,
                'max_delay' => null,
            ],
            [
                'name' => 'Poursuivre l\'expropriation : DEPOSER CAHIER DE CHARGES',
                'code' => ConvHypothecState::EXPROPRIATION_SPECIFICATION,
                'type' => 'realization',
                'rank' => 4,
                'min_delay' => null,
                'max_delay' => 50,
            ],
            // [
            //     'name' => 'Poursuivre l\'expropriation : FIXER DATE DE LA VENTE',
            //     'code' => ConvHypothecState::EXPROPRIATION_SALE,
            //     'type' => 'realization',
            //     'rank' => 5,
            //     'min_delay' => 45,
            //     'max_delay' => 90,
            // ],
            [
                'name' => 'Poursuivre l\'expropriation : ADRESSER SOMMATION A PRENDRE CONNAISSANCE DU CAHIER DES CHARGES',
                'code' => ConvHypothecState::EXPROPRIATION_SUMMATION,
                'type' => 'realization',
                'rank' => 5,
                'min_delay' => null,
                'max_delay' => 8,
            ],
            [
                'name' => 'Publicité de vente',
                'code' => ConvHypothecState::ADVERTISEMENT,
                'type' => 'realization',
                'rank' => 6,
                'min_delay' => 15,
                'max_delay' => 30,
            ],
            [
                'name' => 'Vente de l\'immeuble',
                'code' => ConvHypothecState::PROPERTY_SALE,
                'type' => 'realization',
                'rank' => 7,
                'min_delay' => null,
                'max_delay' => null,
            ],
        ];
    }
}
