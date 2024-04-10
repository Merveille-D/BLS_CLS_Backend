<?php

namespace Database\Seeders\Litigation;

use App\Enums\Litigation\LitigationType;
use App\Models\Litigation\LitigationResource;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class LitigationResourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $resources = $this->litigation_natures();
        foreach ($resources as $resource) {
            $exist = LitigationResource::where('name', $resource)->first();
            if (!$exist) {
                LitigationResource::create(['name' => $resource, 'type' => LitigationType::NATURE] );
            }
        }

        $jurisdictions = $this->litigation_jurisdictions();
        foreach ($jurisdictions as $jurisdiction) {
            $exist = LitigationResource::where('name', $jurisdiction)->first();
            if (!$exist) {
                LitigationResource::create(['name' => $jurisdiction, 'type' => LitigationType::JURISDICTION] );
            }
        }
    }

    /**
     * nature default seeds
     *
     * @return array
     */
    public function litigation_natures() : array {
        return [
            'Administrative',
            'Civile',
            'Commerciale',
            'Penale',
            'Sociale',
        ];
    }

    /**
     * jurisdictions default seeds
     *
     * @return array
     */
    public function litigation_jurisdictions() : array {
        return [
            'Tribunal de Première Instance',
            'Tribunal de Commerce',
            'Tribunal Administratif',
            'Cour d\'Appel',
            'Cour Suprême ',
            'Cour Constitutionnelle',
        ];
    }
}
