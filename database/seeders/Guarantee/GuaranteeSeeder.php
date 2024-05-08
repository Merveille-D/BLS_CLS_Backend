<?php

namespace Database\Seeders\Guarantee;

use App\Enums\ConvHypothecState;
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
        $steps = $this->getSteps();

        foreach ($steps as $step) {
            $exist = GuaranteeStep::where('code', $step['code'])->whereGuaranteeType($step['guarantee_type'])->first();
            if (!$exist)
                GuaranteeStep::create($step);
        }

    }


    function getSteps() : array {
        return [
            [
                'title' => 'Initiation de la garantie',
                'code' => BondState::CREATED,
                'guarantee_type' => GuaranteeType::AUTONOMOUS_GUARANTEE,
                'step_type' => 'formalization',
                'rank' => 1,
                'min_delay' => null,
                'max_delay' => 10,
            ],
            [
                'title' => 'VERIFICATION DE LA VALIDITE DU CONTRAT DE CAUTIONNEMENT (ECRIT ET MENTIONS OBLIGATOIRES)',
                'guarantee_type' => GuaranteeType::AUTONOMOUS_GUARANTEE,
                'code' => BondState::VERIFICATION,
                'step_type' => 'formalization',
                'rank' => 1,
                'min_delay' => null,
                'max_delay' => 10,
            ],
            [
                'title' => 'COMMUNICATION DE L\'ETAT DES DETTES DU DEBITEUR A FAIRE A LA CAUTION AU PLUS TARD TOUS LES 7 MOIS',
                'guarantee_type' => GuaranteeType::AUTONOMOUS_GUARANTEE,
                'code' => BondState::COMMUNICATION,
                'step_type' => 'formalization',
                'rank' => 1,
                'min_delay' => null,
                'max_delay' => 210,
            ],

            //realization

            [
                'title' => 'Mise en demeure adressée au débiteur principal',
                'guarantee_type' => GuaranteeType::AUTONOMOUS_GUARANTEE,
                'code' => BondState::DEBTOR_FORMAL_NOTICE,
                'step_type' => 'realization',
                'rank' => 1,
                'min_delay' => null,
                'max_delay' => 10,
            ],
            [
                'title' => 'INFORMATION DE LA CAUTION',
                'guarantee_type' => GuaranteeType::AUTONOMOUS_GUARANTEE,
                'code' => BondState::INFORM_GUARANTOR,
                'step_type' => 'realization',
                'rank' => 1,
                'min_delay' => null,
                'max_delay' => 10,
            ],
            [
                'title' => 'MISE EN DEMEURE DE LA CAUTION',
                'guarantee_type' => GuaranteeType::AUTONOMOUS_GUARANTEE,
                'code' => BondState::GUARANTOR_FORMAL_NOTICE,
                'step_type' => 'realization',
                'rank' => 1,
                'min_delay' => null,
                'max_delay' => 10,
            ],
            [
                'title' => 'PAIEMENT DE LA CAUTION',
                'guarantee_type' => GuaranteeType::AUTONOMOUS_GUARANTEE,
                'code' => BondState::GUARANTOR_PAYMENT,
                'step_type' => 'realization',
                'rank' => 1,
                'min_delay' => null,
                'max_delay' => 10,
            ],

        ];
    }
}
