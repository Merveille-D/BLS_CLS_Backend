<?php

namespace App\Concerns\Traits\Guarantee;

use App\Enums\Guarantee\GuaranteeType;

trait DefaultGuaranteeTaskTrait
{
    public function getStockSteps()
    {
        $steps =  [
            [
                'title' => 'Rédaction de la convention de garantie',
                'code' => 'redaction',
                'guarantee_type' => GuaranteeType::STOCK,
                'step_type' => 'formalization',
                'rank' => 1,
                'min_delay' => null,
                'max_delay' => 10,
                'formalization_type' => 'conventionnal'
            ],
            [
                'title' => 'Dépot de la convention au rang des minutes d\'un notaire',
                'code' => 'notary_deposit',
                'guarantee_type' => GuaranteeType::STOCK,
                'step_type' => 'formalization',
                'rank' => 2,
                'min_delay' => null,
                'max_delay' => 10,
                'formalization_type' => 'conventionnal'
            ],
            [
                'title' => 'Transmission au notaire d\'une demande d\'incription de la garantie au RCCM',
                'code' => 'notary_transmission',
                'guarantee_type' => GuaranteeType::STOCK,
                'step_type' => 'formalization',
                'rank' => 3,
                'min_delay' => null,
                'max_delay' => 10,
                'formalization_type' => 'conventionnal'
            ],
            [
                'title' => 'Obtention de la convention de garantie enregistrée',
                'code' => 'convention_obtention',
                'guarantee_type' => GuaranteeType::STOCK,
                'step_type' => 'formalization',
                'rank' => 4,
                'min_delay' => null,
                'max_delay' => 10,
                'formalization_type' => 'conventionnal'
            ],
            [
                'title' => 'Envoi d\'une demande par le notaire au RCCM pour enregistrement de la garantie',
                'code' => 'rccm_registration',
                'guarantee_type' => GuaranteeType::STOCK,
                'step_type' => 'formalization',
                'rank' => 5,
                'min_delay' => null,
                'max_delay' => 10,
                'formalization_type' => 'conventionnal'
            ],
            [
                'title' => 'Réception de la preuve d\'inscription de la garantie',
                'code' => 'rccm_proof',
                'guarantee_type' => GuaranteeType::STOCK,
                'step_type' => 'formalization',
                'rank' => 6,
                'min_delay' => null,
                'max_delay' => 10,
                'formalization_type' => 'conventionnal'
            ],

            [
                'title' => 'Saisine de l\'huissier pour les notifications et/ou les formalités de domiciliation avec l\'avis "déclaration favorable"',
                'code' => 'huissier_notification',
                'guarantee_type' => GuaranteeType::STOCK,
                'step_type' => 'formalization',
                'rank' => 7,
                'min_delay' => null,
                'max_delay' => 10,
                'formalization_type' => 'conventionnal'
            ],
            [
                'title' => 'Obtention des actes de domiciliation avec l\'avis "déclaration favorable"',
                'code' => 'domiciliation_obtention',
                'guarantee_type' => GuaranteeType::STOCK,
                'step_type' => 'formalization',
                'rank' => 8,
                'min_delay' => null,
                'max_delay' => 10,
                'formalization_type' => 'conventionnal'
            ],
            [
                'title' => 'Obtention du bordereau de gage de stocks émis par le greffier au débiteur',
                'code' => 'stock_pledge_obtention',
                'guarantee_type' => GuaranteeType::STOCK,
                'step_type' => 'formalization',
                'rank' => 9,
                'min_delay' => null,
                'max_delay' => 10,
                'formalization_type' => 'conventionnal'
            ],

            //legal formalization type
            [
                'title' => 'Saisine de la juridiction compétente',
                'code' => 'referral',
                'guarantee_type' => GuaranteeType::STOCK,
                'step_type' => 'formalization',
                'rank' => 1,
                'min_delay' => null,
                'max_delay' => 10,
                'formalization_type' => 'legal'
            ],
            [
                'title' => 'Obtention de la décision autorisant la garantie',
                'code' => null,
                'guarantee_type' => GuaranteeType::STOCK,
                'step_type' => 'obtention',
                'rank' => 1,
                'min_delay' => null,
                'max_delay' => null,
                'formalization_type' => null
            ],
            [
                'title' => 'Transmission au notaire d\'une demande d\'inscription de la garantie au RCCM',
                'code' => null,
                'guarantee_type' => GuaranteeType::STOCK,
                'step_type' => 'formalization',
                'rank' => 2,
                'min_delay' => null,
                'max_delay' => null,
                'formalization_type' => null
            ],
            [
                'title' => 'Envoi d\'une demande par le notaire au RCCM pour enregistrement de la garantie',
                'code' => null,
                'guarantee_type' => GuaranteeType::STOCK,
                'step_type' => 'formalization',
                'rank' => 3,
                'min_delay' => null,
                'max_delay' => null,
                'formalization_type' => null
            ],
            [
                'title' => 'Réception de la preuve d\'inscription de la garantie',
                'code' => null,
                'guarantee_type' => GuaranteeType::STOCK,
                'step_type' => 'obtention',
                'rank' => 4,
                'min_delay' => null,
                'max_delay' => null,
                'formalization_type' => null
            ],
            [
                'title' => 'Autorisation judiciaire',
                'code' => null,
                'guarantee_type' => GuaranteeType::STOCK,
                'step_type' => 'legal',
                'rank' => 5,
                'min_delay' => null,
                'max_delay' => null,
                'formalization_type' => 'legal'
            ],

            //

        ];


        return collect($steps);
    }
}
