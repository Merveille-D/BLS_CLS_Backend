<?php

namespace Database\Seeders\Evaluation;

use App\Models\Evaluation\PerformanceIndicator;
use App\Models\Evaluation\Position;
use Illuminate\Database\Seeder;

class EvaluationPerformanceIndicatorSeeder extends Seeder
{
    public function run()
    {

        $position = Position::create(['title' => 'Avocat']);

        $indicators = [
            [

                'position_id' => $position->id,

                'items' => [
                    [
                        'title' => 'Critère 1',
                        'note' => 10,
                        'type' => 'quantitative',
                        'description' => 'Bonne qualification professionnelle',
                    ],
                    [
                        'title' => 'Critère 2',
                        'note' => 10,
                        'type' => 'quantitative',
                        'description' => 'Solides compétences et connaissance démontrables de l’environnement juridique',
                    ],
                    [
                        'title' => 'Critère 3',
                        'note' => 15,
                        'type' => 'quantitative',
                        'description' => 'Préférence pour un cabinet spécialisé en droit bancaire, transactions commerciales, financement de projets, télécoms, énergie et travail',
                    ],
                    //
                    [
                        'title' => 'Critère 4',
                        'note' => 3,
                        'type' => 'quantitative',
                        'description' => 'Diffusion du bureau du cabinet d’avocats dans les régions géographiques du pays',
                    ],
                    //
                    [
                        'title' => 'Critère 5',
                        'note' => 5,
                        'type' => 'quantitative',
                        'description' => 'Minimum de dix (10) ans après l’appel pour les principaux partenaires de ceux qui seront considérés pour les mémoires majeurs et minimum de trois (03) ans pour les recherches et la perfection',
                    ],
                    //
                    [
                        'title' => 'Critère 6',
                        'note' => 2,
                        'type' => 'quantitative',
                        'description' => 'Proximité du cabinet d’avocats avec les dossiers traités, notamment les dossiers de recouvrement',
                    ],
                    //
                    [
                        'title' => 'Critère 7',
                        'note' => 3,
                        'type' => 'quantitative',
                        'description' => 'Capacité à sécuriser et à conserver des informations confidentielles',
                    ],
                    //
                    [
                        'title' => 'Critère 8',
                        'note' => 2,
                        'type' => 'quantitative',
                        'description' => 'Organisation du bureau, Outils de communication bureautique standard et Informatisation des opérations',
                    ],
                    //
                    [
                        'title' => 'Critère 9',
                        'note' => 10,
                        'type' => 'quantitative',
                        'description' => 'Nombre d’associés, de collaborateurs et de personnel administratif',
                    ],
                    //
                    [
                        'title' => 'Critère 10',
                        'note' => 10,
                        'type' => 'quantitative',
                        'description' => 'Réputation du cabinet d’avocats dans la profession',
                    ],
                    //
                    [
                        'title' => 'Critère 11',
                        'note' => 10,
                        'type' => 'quantitative',
                        'description' => 'Expérience dans la gestion réussie de transactions complexes',
                    ],
                    //
                    [
                        'title' => 'Critère 12',
                        'note' => 10,
                        'type' => 'quantitative',
                        'description' => 'Liste des affaires critiques clés qui ont été traitées avec succès par le cabinet d’avocats à la Haute Cour, à la Cour d’appel / Cour suprême',
                    ],
                    //
                    [
                        'title' => 'Critère 13',
                        'note' => 10,
                        'type' => 'quantitative',
                        'description' => 'Considérations sociales/politiques & Activité stratégique que la banque a à gagner en engageant le cabinet',
                    ],

                ],
            ],
        ];

        foreach ($indicators as $indicators) {
            foreach ($indicators['items'] as $item) {

                $item['position_id'] = $indicators['position_id'];

                PerformanceIndicator::create($item);
            }
        }
    }
}
