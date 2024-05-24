<?php

namespace Database\Seeders\Recovery;

use App\Enums\ConvHypothecState;
use App\Enums\Recovery\RecoveryStepEnum;
use App\Models\Guarantee\ConvHypothec;
use App\Models\Guarantee\ConvHypothecStep;
use App\Models\Recovery\Recovery;
use App\Models\Recovery\RecoveryStep;
use App\Repositories\Recovery\RecoveryRepository;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RecoveryResourceSeeder extends Seeder
{
    public function __construct(private RecoveryRepository $recoveryRepository) {}
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $steps = $this->getSteps();

        foreach ($steps as $step) {
            RecoveryStep::create($step);
        }
    }

    function getSteps() : array {
        return [
            [
                'title' => 'Initiation du recouvrement amical',
                'code' => RecoveryStepEnum::CREATED,
                'type' => 'friendly',
                'rank' => 1,
                'min_delay' => null,
                'max_delay' => 10,
            ],
            [
                'title' => "Formalisation de l'acte (Dépôt de l'acte au rang des minutes d'un notaire ou homologatuion)",
                'code' => RecoveryStepEnum::FORMALIZATION,
                'type' => 'friendly',
                'rank' => 2,
                'min_delay' => null,
                'max_delay' => 10,
            ],

            //forced with guarantee
            [
                'title' => 'Initialisation du recouvrement forcé',
                'code' => RecoveryStepEnum::CREATED,
                'type' => 'forced',
                'rank' => 1,
                'min_delay' => null,
                'max_delay' => 10,
            ],
            [
                'title' => "Mise en demeure de payer adressée au client débiteur",
                'code' => RecoveryStepEnum::FORMAL_NOTICE,
                'type' => 'forced',
                'rank' => 2,
                'min_delay' => null,
                'max_delay' => 10,
            ],
            [
                'title' => "le débiteur paie sa dette",
                'code' => RecoveryStepEnum::DEBT_PAYEMENT,
                'type' => 'forced',
                'rank' => 3,
                'min_delay' => null,
                'max_delay' => 10,
            ],
            [
                'title' => "Initier une procédure de saisie des biens du débiteur",
                'code' => RecoveryStepEnum::SEIZURE,
                'type' => 'forced',
                'rank' => 4,
                'min_delay' => null,
                'max_delay' => 10,
            ],
            [
                'title' => "Obtenir un titre exécutoire",
                'code' => RecoveryStepEnum::EXECUTORY,
                'type' => 'forced',
                'rank' => 5,
                'min_delay' => null,
                'max_delay' => 10,
            ],
            [
                'title' => "Saisie de la juridiction compétente",
                'code' => RecoveryStepEnum::JURISDICTION,
                'type' => 'forced',
                'rank' => 6,
                'min_delay' => null,
                'max_delay' => 10,
            ],
            [
                'title' => "Confier la procédure à un avocat",
                'code' => RecoveryStepEnum::ENTRUST_LAWYER,
                'type' => 'forced',
                'rank' => 7,
                'min_delay' => null,
                'max_delay' => 10,
            ]
        ];
    }
}
