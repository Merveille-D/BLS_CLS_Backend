<?php

namespace Database\Seeders\Contract;

use App\Models\Contract\ContractCategory;
use App\Models\Contract\ContractTypeCategory;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            [
                'value' => 'Baux',
            ],
            [
                'value' => 'Credits',
                'type_categories' => [
                    [
                        'value' => 'Amortissable',
                    ],
                    [
                        'value' => 'Aval / Escompte',
                    ],
                    [
                        'value' => 'Découvertes / Facilités de caisse',
                    ],
                    [
                        'value' => 'Spots / Relais',
                    ],
                    [
                        'value' => 'Campagne',
                    ],
                    [
                        'value' => 'Syndications',
                    ],
                ],
            ],
            [
                'value' => 'Emplois',
                'type_categories' => [
                    [
                        'value' => 'CDI',
                    ],
                    [
                        'value' => 'CDD',
                    ],
                    [
                        'value' => 'Détachement / Mise en disponibilité',
                    ],
                    [
                        'value' => 'Engagement à l\'essai',
                    ],
                    [
                        'value' => 'Stage académique',
                    ],
                    [
                        'value' => 'Stage professionnel',
                    ],
                ],
            ],
            [
                'value' => 'Garanties',
                'type_categories' => [
                    [
                        'value' => 'Garanties',
                    ],
                    [
                        'value' => 'Sûretés personnelles',
                        'sub_type_categories' => [
                            [
                                'value' => 'Cautionnement',
                            ],
                            [
                                'value' => 'Garantie autonome',
                            ],
                            [
                                'value' => 'Contre garantie autonomes',
                            ],
                        ],
                    ],
                    [
                        'value' => 'Sûretés immobilières',
                    ],
                ],
            ],
            [
                'value' => 'Services',
                'type_categories' => [
                    [
                        'value' => 'Fournisseur',
                    ],
                    [
                        'value' => 'Prestataire',
                    ],
                ],
            ],
        ];

        foreach ($categories as $value) {

            $category = ContractCategory::create([
                'value' => $value['value'],
            ]);

            if (isset($value['type_categories'])) {

                foreach ($value['type_categories'] as $item) {

                    $type_category = ContractTypeCategory::create([
                        'value' => $item['value'],
                        'contract_category_id' => $category->id,
                    ]);

                    if (isset($value['sub_type_categories'])) {

                        foreach ($item['sub_type_categories'] as $sub_type_category) {

                            ContractTypeCategory::create([
                                'value' => $sub_type_category['value'],
                                'contract_type_category_id' => $type_category->id,
                            ]);
                        }
                    }
                }
            }
        }
    }
}
