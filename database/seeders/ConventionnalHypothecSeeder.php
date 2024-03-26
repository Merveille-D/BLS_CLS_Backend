<?php

namespace Database\Seeders;

use App\Models\Guarantee\ConventionnalHypothecs\HypothecStep;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConventionnalHypothecSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->steps() as $key => $value) {
            HypothecStep::create([
                'name' => $value[0],
                'type' => $value[1],
            ]);
        }
    }

    function steps() : array {
        return [
            ['CONTRAT PRINCIPAL', 'FORMALISATION'],
            ['VERIFICATION DE LA PROPRIETE DE L\'IMMEUBLE', 'FORMALISATION'],
            ["REDIGER CONVENTION D'HYPOTHEQUE", 'FORMALISATION'],
            ["DEMANDE D'INSCRIPTION", 'FORMALISATION'],
            ["INSCRIPTION", 'FORMALISATION'],
            ["SIGNIFICATION COMMENDEMENT DE PAYER", 'REALISATION'],
            ["DEMANDE D'INSCRIPTION ET PUBLICATION DU COMMENDEMENT DE PAYER DANS LES REGISTRES DE LA PROPRIETE FONCIERE", 'REALISATION'],
            ["SAISIE IMMOBILIERE APRES VISA DU REGISSUER SUR LE COMMENDEMENT DE PAYER", 'REALISATION'],
            ["POURSUIVRE L'EXPROPRIATION", 'REALISATION'],
            ["PUBLICITE EN VUE DE LA VENTE", 'REALISATION'],
            ["VENTE DE L'IMMEUBLE", 'REALISATION']
        ];
    }
}
