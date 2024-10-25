<?php

namespace App\Concerns\Traits\Recovery;

use App\Enums\Recovery\RecoveryStepEnum;

trait RecoveryNotificationTrait
{
    public function nextStepBasedOnState($recovery): array
    {
        $data = [
            'message' => '',
        ];

        switch ($recovery->status) {
            case RecoveryStepEnum::CREATED:
                if ($recovery->type == 'friendly') {
                    $data['message'] = 'Formalisation de l\'acte (Dépôt de l\'acte au rang des minutes d\'un notaire ou homologation)';
                } else {
                    $data['message'] = 'Procéder à la mise en demeure de payer adressée au client débiteur';
                }
                break;

            case RecoveryStepEnum::FORMAL_NOTICE:
                $data['message'] = 'Procéder à la vérification si le débiteur a payé la dette';
                break;
            case RecoveryStepEnum::DEBT_PAYEMENT:
                $data['message'] = 'Procéder à l\'initiation d\'une procédure de saisie des biens du débiteur';
                break;
            case RecoveryStepEnum::SEIZURE:
                $data['message'] = 'Procéder à l\'obtention d\'un titre exécutoire';
                break;
            case RecoveryStepEnum::EXECUTORY:
                $data['message'] = 'Procéder à la saisie de la juridiction compétente';
                break;
            case RecoveryStepEnum::JURISDICTION:
                $data['message'] = 'Confier la procédure à un avocat';
                break;

            default:
                //
                break;
        }

        return $data;
    }
}
