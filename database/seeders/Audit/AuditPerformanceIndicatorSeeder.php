<?php

namespace Database\Seeders\Audit;

use App\Models\Audit\AuditPerformanceIndicator;
use Illuminate\Database\Seeder;

class AuditPerformanceIndicatorSeeder extends Seeder
{
    public function run()
    {

        $indicators = [
            [
                'module' => 'conventionnal_hypothec',
                'items' => [
                    [
                        'title' => 'Evaluer la pertinence et la nature de litige qualifié de contentieux.',
                        'note' => 5,
                        'type' => 'quantitative',
                        'description' => 'Le préalable à faire',
                    ],
                    [
                        'title' => 'S’assurer de la réalisation des relances nécessaires (Mise en demeure, sommation de payer…).',
                        'note' => 5,
                        'type' => 'quantitative',
                        'description' => 'Le préalable à faire',
                    ],
                    [
                        'title' => 'Evaluer le risque et les coûts pour la banque en cas de procédure judiciaire.',
                        'note' => 5,
                        'type' => 'quantitative',
                        'description' => 'Le préalable à faire',
                    ],
                    [
                        'title' => 'Introduire une procédure de conciliation ou de médiation dès la constatation du litige',
                        'note' => 5,
                        'type' => 'quantitative',
                        'description' => 'Prioriser le règlement amiable du contentieux',
                    ],
                    [
                        'title' => 'Rechercher une solution négociée entre la banque et la partie adverse.',
                        'note' => 10,
                        'type' => 'quantitative',
                        'description' => 'Prioriser le règlement amiable du contentieux',
                    ],
                    [
                        'title' => 'Faire homologuer ou authentifier le procès-verbal de la tentative de conciliation.',
                        'note' => 5,
                        'type' => 'quantitative',
                        'description' => 'Prioriser le règlement amiable du contentieux',
                    ],
                    [
                        'title' => 'Vérifier l’existence ou non d’une clause compromissoire ou d’un compromis',
                        'note' => 5,
                        'type' => 'quantitative',
                        'description' => 'Saisir les juridictions compétentes',
                    ],
                    [
                        'title' => 'S’assurer de la saisine de la juridiction territorialement et matériellement compétente.',
                        'note' => 5,
                        'type' => 'quantitative',
                        'description' => 'Saisir les juridictions compétentes',
                    ],
                    [
                        'title' => 'Veiller à la constitution d’un dossier solide (pièces justificatives et arguments utiles).',
                        'note' => 10,
                        'type' => 'quantitative',
                        'description' => 'Transmettre le dossier à un conseil',
                    ],
                    [
                        'title' => 'Veiller à choisir un conseil expérimenté dans le domaine du litige.',
                        'note' => 10,
                        'type' => 'quantitative',
                        'description' => 'Transmettre le dossier à un conseil',
                    ],
                    [
                        'title' => 'Assurer la veille juridique (application de la bonne loi au litige en cours)',
                        'note' => 5,
                        'type' => 'quantitative',
                        'description' => 'Suivre de près le dossier de contentieux',
                    ],
                    [
                        'title' => 'Communiquer les informations administratives nécessaires au bon déroulement de la procédure',
                        'note' => 8,
                        'type' => 'quantitative',
                        'description' => 'Suivre de près le dossier de contentieux',
                    ],
                    [
                        'title' => 'Aider au rassemblement des éléments de preuve au profit de la banque',
                        'note' => 7,
                        'type' => 'quantitative',
                        'description' => 'Suivre de près le dossier de contentieux',
                    ],
                    [
                        'title' => 'Veiller au respect des dates d’audiences ainsi que des délais de recours.',
                        'note' => 5,
                        'type' => 'quantitative',
                        'description' => 'Suivre de près le dossier de contentieux',
                    ],
                    [
                        'title' => 'Faire les diligences nécessaires afin d’obtenir les grosses des décisions de justice.',
                        'note' => 10,
                        'type' => 'quantitative',
                        'description' => 'Assurer l’exécution des décisions de justice
',
                    ],
                ],
            ],
            [
                'module' => 'conventionnal_hypothec',
                'items' => [
                    [
                        'title' => 'Titre de propriété à jour',
                        'note' => 10,
                        'type' => 'quantitative',
                        'description' => 'Check-in de la documentation',
                    ],
                    [
                        'title' => 'Acte notarié de formalisation de garantie principale à jour',
                        'note' => 10,
                        'type' => 'quantitative',
                        'description' => 'Check-in de la documentation',
                    ],
                    [
                        'title' => 'Informations sur les garanties accessoires à jour',
                        'note' => 5,
                        'type' => 'quantitative',
                        'description' => 'Check-in de la documentation',
                    ],
                    [
                        'title' => 'Antécédents de crédit',
                        'note' => 10,
                        'type' => 'quantitative',
                        'description' => 'Check-in  de la solvabilité',
                    ],
                    [
                        'title' => 'Stabilité financière',
                        'note' => 5,
                        'type' => 'quantitative',
                        'description' => 'Check-in  de la solvabilité',
                    ],
                    [
                        'title' => 'Capacité de remboursement (Ratio dette / revenu)',
                        'note' => 5,
                        'type' => 'quantitative',
                        'description' => 'Check-in  de la solvabilité',
                    ],
                    [
                        'title' => 'Respect des échéanciers de remboursement',
                        'note' => 10,
                        'type' => 'quantitative',
                        'description' => 'Check-in  de la solvabilité',
                    ],
                    [
                        'title' => 'Qualité des garanties',
                        'note' => 10,
                        'type' => 'quantitative',
                        'description' => 'Check-in  de la solvabilité',
                    ],
                    [
                        'title' => 'Rappel périodique des échéanciers de payement',
                        'note' => 5,
                        'type' => 'quantitative',
                        'description' => 'Suivi et gestion du portefeuille',
                    ],
                    [
                        'title' => 'Respect des délais d’information client/tiers intéressés',
                        'note' => 5,
                        'type' => 'quantitative',
                        'description' => 'Suivi et gestion du portefeuille',
                    ],
                    [
                        'title' => 'Actualisation/mis à jour périodique de la garantie',
                        'note' => 10,
                        'type' => 'quantitative',
                        'description' => 'Suivi et gestion du portefeuille',
                    ],
                    [
                        'title' => 'Veille  continuelle de conformité réglementaire',
                        'note' => 5,
                        'type' => 'quantitative',
                        'description' => 'Suivi et gestion du portefeuille',
                    ],
                    [
                        'title' => 'Evaluation continuelle de solvabilité',
                        'note' => 5,
                        'type' => 'quantitative',
                        'description' => 'Suivi et gestion du portefeuille',
                    ],
                    [
                        'title' => 'Dossiers à jour et bien rangé',
                        'note' => 5,
                        'type' => 'quantitative',
                        'description' => 'Classement',
                    ],
                ],
            ],
            [
                'module' => 'guarantees_security_movable',
                'items' => [
                    [
                        'title' => 'Titre de propriété à jour',
                        'note' => 10,
                        'type' => 'quantitative',
                        'description' => 'Check-in de la documentation',
                    ],
                    [
                        'title' => 'Acte notarié de formalisation de garantie principale à jour',
                        'note' => 10,
                        'type' => 'quantitative',
                        'description' => 'Check-in de la documentation',
                    ],
                    [
                        'title' => 'Informations sur les garanties accessoires à jour',
                        'note' => 5,
                        'type' => 'quantitative',
                        'description' => 'Check-in de la documentation',
                    ],
                    [
                        'title' => 'Antécédents de crédit',
                        'note' => 10,
                        'type' => 'quantitative',
                        'description' => 'Check-in  de la solvabilité',
                    ],
                    [
                        'title' => 'Stabilité financière',
                        'note' => 5,
                        'type' => 'quantitative',
                        'description' => 'Check-in  de la solvabilité',
                    ],
                    [
                        'title' => 'Capacité de remboursement (Ratio dette / revenu)',
                        'note' => 5,
                        'type' => 'quantitative',
                        'description' => 'Check-in  de la solvabilité',
                    ],
                    [
                        'title' => 'Respect des échéanciers de remboursement',
                        'note' => 10,
                        'type' => 'quantitative',
                        'description' => 'Check-in  de la solvabilité',
                    ],
                    [
                        'title' => 'Qualité des garanties',
                        'note' => 10,
                        'type' => 'quantitative',
                        'description' => 'Check-in  de la solvabilité',
                    ],
                    [
                        'title' => 'Rappel périodique des échéanciers de payement',
                        'note' => 5,
                        'type' => 'quantitative',
                        'description' => 'Suivi et gestion du portefeuille',
                    ],
                    [
                        'title' => 'Respect des délais d’information client/tiers intéressés',
                        'note' => 5,
                        'type' => 'quantitative',
                        'description' => 'Suivi et gestion du portefeuille',
                    ],
                    [
                        'title' => 'Actualisation/mis à jour périodique de la garantie',
                        'note' => 10,
                        'type' => 'quantitative',
                        'description' => 'Suivi et gestion du portefeuille',
                    ],
                    [
                        'title' => 'Veille  continuelle de conformité réglementaire',
                        'note' => 5,
                        'type' => 'quantitative',
                        'description' => 'Suivi et gestion du portefeuille',
                    ],
                    [
                        'title' => 'Evaluation continuelle de solvabilité',
                        'note' => 5,
                        'type' => 'quantitative',
                        'description' => 'Suivi et gestion du portefeuille',
                    ],
                    [
                        'title' => 'Dossiers à jour et bien rangé',
                        'note' => 5,
                        'type' => 'quantitative',
                        'description' => 'Classement',
                    ],
                ],
            ],
            [
                'module' => 'guarantees_security_personal',
                'items' => [
                    [
                        'title' => 'Titre de propriété à jour',
                        'note' => 10,
                        'type' => 'quantitative',
                        'description' => 'Check-in de la documentation',
                    ],
                    [
                        'title' => 'Acte notarié de formalisation de garantie principale à jour',
                        'note' => 10,
                        'type' => 'quantitative',
                        'description' => 'Check-in de la documentation',
                    ],
                    [
                        'title' => 'Informations sur les garanties accessoires à jour',
                        'note' => 5,
                        'type' => 'quantitative',
                        'description' => 'Check-in de la documentation',
                    ],
                    [
                        'title' => 'Antécédents de crédit',
                        'note' => 10,
                        'type' => 'quantitative',
                        'description' => 'Check-in  de la solvabilité',
                    ],
                    [
                        'title' => 'Stabilité financière',
                        'note' => 5,
                        'type' => 'quantitative',
                        'description' => 'Check-in  de la solvabilité',
                    ],
                    [
                        'title' => 'Capacité de remboursement (Ratio dette / revenu)',
                        'note' => 5,
                        'type' => 'quantitative',
                        'description' => 'Check-in  de la solvabilité',
                    ],
                    [
                        'title' => 'Respect des échéanciers de remboursement',
                        'note' => 10,
                        'type' => 'quantitative',
                        'description' => 'Check-in  de la solvabilité',
                    ],
                    [
                        'title' => 'Qualité des garanties',
                        'note' => 10,
                        'type' => 'quantitative',
                        'description' => 'Check-in  de la solvabilité',
                    ],
                    [
                        'title' => 'Rappel périodique des échéanciers de payement',
                        'note' => 5,
                        'type' => 'quantitative',
                        'description' => 'Suivi et gestion du portefeuille',
                    ],
                    [
                        'title' => 'Respect des délais d’information client/tiers intéressés',
                        'note' => 5,
                        'type' => 'quantitative',
                        'description' => 'Suivi et gestion du portefeuille',
                    ],
                    [
                        'title' => 'Actualisation/mis à jour périodique de la garantie',
                        'note' => 10,
                        'type' => 'quantitative',
                        'description' => 'Suivi et gestion du portefeuille',
                    ],
                    [
                        'title' => 'Veille  continuelle de conformité réglementaire',
                        'note' => 5,
                        'type' => 'quantitative',
                        'description' => 'Suivi et gestion du portefeuille',
                    ],
                    [
                        'title' => 'Evaluation continuelle de solvabilité',
                        'note' => 5,
                        'type' => 'quantitative',
                        'description' => 'Suivi et gestion du portefeuille',
                    ],
                    [
                        'title' => 'Dossiers à jour et bien rangé',
                        'note' => 5,
                        'type' => 'quantitative',
                        'description' => 'Classement',
                    ],
                ],
            ],
        ];

        foreach ($indicators as $indicators) {
            foreach ($indicators['items'] as $item) {
                $item['module'] = $indicators['module'];
                AuditPerformanceIndicator::create($item);
            }
        }
    }
}
