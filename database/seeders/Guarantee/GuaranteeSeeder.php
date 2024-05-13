<?php

namespace Database\Seeders\Guarantee;

use App\Enums\ConvHypothecState;
use App\Enums\Guarantee\AutonomousCounterState;
use App\Enums\Guarantee\AutonomousState;
use App\Enums\Guarantee\BondState;
use App\Enums\Guarantee\GuaranteeType;
use App\Models\Guarantee\GuaranteeStep;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GuaranteeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $steps = $this->getBondSteps();

        foreach ($steps as $step) {
            $exist = GuaranteeStep::where('code', $step['code'])->whereGuaranteeType($step['guarantee_type'])->first();
            if (!$exist)
                GuaranteeStep::create($step);
        }

    }


    function getBondSteps() : array {
        return [
            [
                'title' => 'Initiation de la garantie',
                'code' => BondState::CREATED,
                'guarantee_type' => GuaranteeType::BONDING,
                'step_type' => 'formalization',
                'rank' => 1,
                'min_delay' => null,
                'max_delay' => 10,
            ],
            [
                'title' => 'VERIFICATION DE LA VALIDITE DU CONTRAT DE CAUTIONNEMENT (ECRIT ET MENTIONS OBLIGATOIRES)',
                'guarantee_type' => GuaranteeType::BONDING,
                'code' => BondState::VERIFICATION,
                'step_type' => 'formalization',
                'rank' => 2,
                'min_delay' => null,
                'max_delay' => 10,
            ],
            [
                'title' => 'COMMUNICATION DE L\'ETAT DES DETTES DU DEBITEUR A FAIRE A LA CAUTION AU PLUS TARD TOUS LES 7 MOIS',
                'guarantee_type' => GuaranteeType::BONDING,
                'code' => BondState::COMMUNICATION,
                'step_type' => 'formalization',
                'rank' => 3,
                'min_delay' => null,
                'max_delay' => 210,
            ],

            //realization

            [
                'title' => 'Mise en demeure adressée au débiteur principal',
                'guarantee_type' => GuaranteeType::BONDING,
                'code' => BondState::DEBTOR_FORMAL_NOTICE,
                'step_type' => 'realization',
                'rank' => 1,
                'min_delay' => null,
                'max_delay' => 10,
            ],
            [
                'title' => 'INFORMER LA CAUTION DANS LE MOIS DE LA MISE EN DEMEURE DU DEBITEUR RESTER SANS EFFET',
                'guarantee_type' => GuaranteeType::BONDING,
                'code' => BondState::INFORM_GUARANTOR,
                'step_type' => 'realization',
                'rank' => 2,
                'min_delay' => null,
                'max_delay' => 10,
            ],
            [
                'title' => 'MISE EN DEMEURE DE LA CAUTION',
                'guarantee_type' => GuaranteeType::BONDING,
                'code' => BondState::GUARANTOR_FORMAL_NOTICE,
                'step_type' => 'realization',
                'rank' => 3,
                'min_delay' => null,
                'max_delay' => 10,
            ],
            [
                'title' => 'PAIEMENT PAR LA CAUTION',
                'guarantee_type' => GuaranteeType::BONDING,
                'code' => BondState::GUARANTOR_PAYMENT,
                'step_type' => 'realization',
                'rank' => 4,
                'min_delay' => null,
                'max_delay' => 10,
            ],

        ];
    }

    public function getAutonomousSteps() {
        return [
            [
                'title' => 'Initiation de la garantie',
                'code' => AutonomousState::CREATED,
                'guarantee_type' => GuaranteeType::AUTONOMOUS,
                'step_type' => 'formalization',
                'rank' => 1,
                'min_delay' => null,
                'max_delay' => 10,
            ],
            [
                'title' => 'Vérification de la validité du contrat',
                'guarantee_type' => GuaranteeType::AUTONOMOUS,
                'code' => AutonomousState::VERIFICATION,
                'step_type' => 'formalization',
                'rank' => 2,
                'min_delay' => null,
                'max_delay' => 10,
            ],
            [
                'title' => 'SIGNATURE DU CONTRAT DE GARANTIE AUTONOME',
                'guarantee_type' => GuaranteeType::AUTONOMOUS,
                'code' => AutonomousState::SIGNATURE,
                'step_type' => 'formalization',
                'rank' => 3,
                'min_delay' => null,
                'max_delay' => 10,
            ],
            [
                'title' => 'DEMANDE DE PAIEMENT ADRESSE AU GARANT',
                'guarantee_type' => GuaranteeType::AUTONOMOUS,
                'code' => AutonomousState::PAYEMENT_REQUEST,
                'step_type' => 'realization',
                'rank' => 1,
                'min_delay' => null,
                'max_delay' => 10,
            ],
            [
                'title' => 'VERIFICATION DE LA DEMANDE PAR LE GARANT',
                'guarantee_type' => GuaranteeType::AUTONOMOUS,
                'code' => AutonomousState::REQUEST_VERIFICATION,
                'step_type' => 'realization',
                'rank' => 2,
                'min_delay' => null,
                'max_delay' => 10,
            ],
        ];
    }

    public function getCounterAutonomousStep() {
        return [
            [
                'title' => 'Initiation de la contre garantie',
                'code' => AutonomousCounterState::CREATED,
                'guarantee_type' => GuaranteeType::AUTONOMOUS_COUNTER,
                'step_type' => 'formalization',
                'rank' => 1,
                'min_delay' => null,
                'max_delay' => 10,
            ],
            [
                'title' => 'Vérification de la validité du contrat',
                'guarantee_type' => GuaranteeType::AUTONOMOUS_COUNTER,
                'code' => AutonomousCounterState::VERIFICATION,
                'step_type' => 'formalization',
                'rank' => 2,
                'min_delay' => null,
                'max_delay' => 10,
            ],
            [
                'title' => 'SIGNATURE DU CONTRAT DE GARANTIE AUTONOME',
                'guarantee_type' => GuaranteeType::AUTONOMOUS_COUNTER,
                'code' => AutonomousCounterState::SIGNATURE,
                'step_type' => 'formalization',
                'rank' => 3,
                'min_delay' => null,
                'max_delay' => 10,
            ],
            [
                'title' => 'DEMANDE DE PAIEMENT ADRESSE AU GARANT',
                'guarantee_type' => GuaranteeType::AUTONOMOUS_COUNTER,
                'code' => AutonomousCounterState::GUARANTOR_PAYEMENT_REQUEST,
                'step_type' => 'realization',
                'rank' => 1,
                'min_delay' => null,
                'max_delay' => 10,
            ],
            [
                'title' => 'DEMANDE DE PAIEMENT ADRESSE AU CONTRE GARANT',
                'guarantee_type' => GuaranteeType::AUTONOMOUS_COUNTER,
                'code' => AutonomousCounterState::COUNTER_GUARD_REQUEST,
                'step_type' => 'realization',
                'rank' => 2,
                'min_delay' => null,
                'max_delay' => 10,
            ],
            [
                'title' => 'VERIFICATION DE LA DEMANDE PAR LE CONTRE GARANT',
                'guarantee_type' => GuaranteeType::AUTONOMOUS_COUNTER,
                'code' => AutonomousCounterState::REQUEST_VERIFICATION,
                'step_type' => 'realization',
                'rank' => 3,
                'min_delay' => null,
                'max_delay' => 10,
            ],

        ];
    }
}
