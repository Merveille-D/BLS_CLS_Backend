<?php

namespace Database\Seeders\Guarantee;

use App\Concerns\Traits\Guarantee\DefaultGuaranteeTaskTrait;
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
    use DefaultGuaranteeTaskTrait;
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

        $steps2 = $this->getAutonomousSteps();

        foreach ($steps2 as $step) {
            $exist = GuaranteeStep::where('code', $step['code'])->whereGuaranteeType($step['guarantee_type'])->first();
            if (!$exist)
                GuaranteeStep::create($step);
        }

        $steps3 = $this->getCounterAutonomousStep();

        foreach ($steps3 as $step) {
            $exist = GuaranteeStep::where('code', $step['code'])->whereGuaranteeType($step['guarantee_type'])->first();
            if (!$exist)
                GuaranteeStep::create($step);
        }

        $stock_steps = $this->getStockSteps();

        foreach ($stock_steps as $step) {
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
            //attacher date et un contrat de cautionnement
            [
                'title' => 'Rédaction du contrat de cautionnement',
                'guarantee_type' => GuaranteeType::BONDING,
                'code' => BondState::REDACTION,
                'step_type' => 'formalization',
                'rank' => 2,
                'min_delay' => null,
                'max_delay' => 10,
            ],
            // completer
            [
                'title' => 'VERIFICATION DE LA VALIDITE DU CONTRAT DE CAUTIONNEMENT (ECRIT ET MENTIONS OBLIGATOIRES)',
                'guarantee_type' => GuaranteeType::BONDING,
                'code' => BondState::VERIFICATION,
                'step_type' => 'formalization',
                'rank' => 3,
                'min_delay' => null,
                'max_delay' => 10,
            ],
            // A completer
            [
                'title' => 'VERIFICATION DE LA SOLVABILITE DE LA CAUTION',
                'guarantee_type' => GuaranteeType::BONDING,
                'code' => BondState::VERIFICATION,
                'step_type' => 'formalization',
                'rank' => 4,
                'min_delay' => null,
                'max_delay' => 10,
            ],

            //inserer date et doc de communication
            [
                'title' => 'COMMUNICATION DE L\'ETAT DES DETTES DU DEBITEUR A FAIRE A LA CAUTION AU PLUS TARD TOUS LES 7 MOIS',
                'guarantee_type' => GuaranteeType::BONDING,
                'code' => BondState::COMMUNICATION,
                'step_type' => 'formalization',
                'rank' => 5,
                'min_delay' => null,
                'max_delay' => 180,
            ],

            //realization doc, date
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
                'title' => 'EXECUTION PAR LE DEBITEUR',
                'guarantee_type' => GuaranteeType::BONDING,
                'code' => BondState::EXECUTION,
                'step_type' => 'realization',
                'rank' => 2,
                'min_delay' => null,
                'max_delay' => 10,
            ],
            [
                'title' => 'INFORMER LA CAUTION DANS LE MOIS DE LA MISE EN DEMEURE DU DEBITEUR RESTER SANS EFFET',
                'guarantee_type' => GuaranteeType::BONDING,
                'code' => BondState::INFORM_GUARANTOR,
                'step_type' => 'realization',
                'rank' => 3,
                'min_delay' => null,
                'max_delay' => 30, // ajouter a date de mise ne demeure
            ],
            // documenjt et  date
            [
                'title' => 'MISE EN DEMEURE DE LA CAUTION',
                'guarantee_type' => GuaranteeType::BONDING,
                'code' => BondState::GUARANTOR_FORMAL_NOTICE,
                'step_type' => 'realization',
                'rank' => 4,
                'min_delay' => null,
                'max_delay' => 10,
            ],
            [
                'title' => 'PAIEMENT PAR LA CAUTION',
                'guarantee_type' => GuaranteeType::BONDING,
                'code' => BondState::GUARANTOR_PAYMENT,
                'step_type' => 'realization',
                'rank' => 5,
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
            //attacher date et un contrat de cautionnement
            [
                'title' => 'Rédaction du contrat de la garantie autonome',
                'guarantee_type' => GuaranteeType::AUTONOMOUS,
                'code' => AutonomousState::REDACTION,
                'step_type' => 'formalization',
                'rank' => 2,
                'min_delay' => null,
                'max_delay' => 10,
            ],
            [
                'title' => 'Vérification de la validité du contrat',
                'guarantee_type' => GuaranteeType::AUTONOMOUS,
                'code' => AutonomousState::VERIFICATION,
                'step_type' => 'formalization',
                'rank' => 3,
                'min_delay' => null,
                'max_delay' => 10,
            ],
            //CHOISIR LA duree du contrat : gdd ou gdi [revocable/non revokable]
            [
                'title' => 'SIGNATURE DU CONTRAT DE GARANTIE AUTONOME',
                'guarantee_type' => GuaranteeType::AUTONOMOUS,
                'code' => AutonomousState::SIGNATURE,
                'step_type' => 'formalization',
                'rank' => 4,
                'min_delay' => null,
                'max_delay' => 10,
            ],

            //realization
            //doc et date
            [
                'title' => 'DEMANDE DE PAIEMENT ADRESSE AU GARANT',
                'guarantee_type' => GuaranteeType::AUTONOMOUS,
                'code' => AutonomousState::PAYEMENT_REQUEST,
                'step_type' => 'realization',
                'rank' => 1,
                'min_delay' => null,
                'max_delay' => 10,
            ],
            //radio payement, date de paiement
            [
                'title' => 'VERIFICATION DE LA DEMANDE PAR LE GARANT',
                'guarantee_type' => GuaranteeType::AUTONOMOUS,
                'code' => AutonomousState::REQUEST_VERIFICATION,
                'step_type' => 'realization',
                'rank' => 2,
                'min_delay' => null,
                'max_delay' => 5,
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
                'title' => 'Rédaction du contrat de la contre garantie',
                'guarantee_type' => GuaranteeType::AUTONOMOUS_COUNTER,
                'code' => AutonomousCounterState::REDACTION,
                'step_type' => 'formalization',
                'rank' => 2,
                'min_delay' => null,
                'max_delay' => 10,
            ],
            [
                'title' => 'Vérification de la validité du contrat',
                'guarantee_type' => GuaranteeType::AUTONOMOUS_COUNTER,
                'code' => AutonomousCounterState::VERIFICATION,
                'step_type' => 'formalization',
                'rank' => 3,
                'min_delay' => null,
                'max_delay' => 10,
            ],
            [
                'title' => 'SIGNATURE DU CONTRAT DE GARANTIE AUTONOME',
                'guarantee_type' => GuaranteeType::AUTONOMOUS_COUNTER,
                'code' => AutonomousCounterState::SIGNATURE,
                'step_type' => 'formalization',
                'rank' => 4,
                'min_delay' => null,
                'max_delay' => 10,
            ],

            //realization
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
