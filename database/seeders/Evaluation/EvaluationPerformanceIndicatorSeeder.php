<?php
namespace Database\Seeders\Evaluation;

use App\Models\Audit\AuditPerformanceIndicator;
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
                        'title' => 'Qualifications',
                        'note' => 10,
                        'type' => 'quantitative',
                        'description' => 'Bonne qualification professionnelle',
                    ],
                    [
                        'title' => 'Compétences',
                        'note' => 5,
                        'type' => 'quantitative',
                        'description' => 'Solides compétences et connaissance démontrables de l’environnement juridique',
                    ],
                    [
                        'title' => 'Expériences',
                        'note' => 10,
                        'type' => 'quantitative',
                        'description' => 'Minimum de dix (10) ans après l’appel pour les principaux partenaires de ceux qui seront considérés pour les mémoires majeurs et minimum de trois (03) ans pour les recherches et la perfection',
                    ],
                    //
                    [
                        'title' => 'Domaines de spécialisation',
                        'note' => 15,
                        'type' => 'quantitative',
                        'description' => 'Préférence pour un cabinet spécialisé en droit bancaire, transactions commerciales, financement de projets, télécoms, énergie et travail',
                    ],
                    //
                    [
                        'title' => 'Emplacement/étendu',
                        'note' => 5,
                        'type' => 'quantitative',
                        'description' => 'Diffusion du bureau du cabinet d’avocats dans les régions géographiques du pays
                                    Proximité du cabinet d’avocats avec les dossiers traités, notamment les dossiers de recouvrement',
                    ],
                    //
                    [
                        'title' => 'Aménagement des bureaux',
                        'note' => 5,
                        'type' => 'quantitative',
                        'description' => 'Outils de communication bureautique standard
                                        Informatisation des opérations
                                        Organisation du bureau
                                        Capacité à sécuriser et à conserver des informations confidentielles',
                    ],
                    //
                    [
                        'title' => 'Effectif',
                        'note' => 10,
                        'type' => 'quantitative',
                        'description' => 'Nombre d’associés, de collaborateurs et de personnel administratif',
                    ],
                    //
                    [
                        'title' => 'Expérience connue',
                        'note' => 30,
                        'type' => 'quantitative',
                        'description' => 'Réputation du cabinet d’avocats dans la profession
                                        Expérience dans la gestion réussie de transactions complexes
                                        Liste des affaires critiques clés qui ont été traitées avec succès par le cabinet d’avocats à la Haute Cour, à la Cour d’appel / Cour suprême',
                    ],
                    //
                    [
                        'title' => 'Autres facteurs',
                        'note' => 10,
                        'type' => 'quantitative',
                        'description' => 'Il s’agit notamment de facteurs tels que :
                                        • Considérations sociales/politiques
                                        • Activité stratégique que la banque a à gagner en engageant le cabinet',
                    ],
                    
                ]
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
