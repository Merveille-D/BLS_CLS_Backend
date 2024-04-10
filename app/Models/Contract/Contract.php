<?php

namespace App\Models\Contract;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'category',
        'type_category',
        'contract_file',
        'date_signature',
        'date_effective',
        'date_signature',
        'date_renewal',
    ];

    const CONTRACT_CATEGORIES = [
        'leases' => 'Baux',
        'credits' => 'Crédits',
        'jobs' => 'Emplois',
        'warranties' => 'Garanties',
        'services' => 'Services',
    ];

    const CONTRACT_TYPE_CATEGORIES = [
        'lease' => [],
        'credits' => [
            'Amortissable',
            'Aval / Escompte',
            'Découvertes / Facilités de caisse',
            'Spots / Relais',
            'Campagne',
            'Syndications',
        ],
        'job' => [
            'CDI',
            'CDD',
            'Détachement / Mise en disponibilité',
            'Engagement à l\'essai',
            'Stage académique',
            'Stage professionnel',
        ],
        'warranty' => [
            'Garanties',
            'Sûretés personnelles',
            'Sûretés immobilières',
        ],
        'service' => [
            'Fournisseur',
            'Prestataire',
        ],
    ];
}
