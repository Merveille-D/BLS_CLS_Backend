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

    const CATEGORIES = [
        'leases',
        'credits',
        'jobs',
        'warranties',
        'services',
    ];

    const TYPE_CATEGORIES = [
        'lease' => [],
        'credits' => [
            'amortizable',
            'aval_discount',
            'discoveries_ovecouvertes',
            'spots_relay',
            'campaign',
            'syndications',
        ],
        'job' => [
            'cdi',
            'cdd',
            'secondment',
            'trial_engagement',
            'academic_internship',
            'professional_internship',
        ],
        'warranty' => [
            'guarantees',
            'personal_sureties',
            'real_estate_sureties',
        ],
        'service' => [
            'supplier',
            'service_provider',
        ],
    ];

    const CATEGORIES_VALUES = [
        'leases' => 'Baux',
        'credits' => 'Crédits',
        'jobs' => 'Emplois',
        'warranties' => 'Garanties',
        'services' => 'Services',
    ];

    const TYPE_CATEGORIES_VALUES = [
        'lease' => [],
        'credits' => [
            'amortizable' => 'Amortissable',
            'aval_discount' => 'Aval / Escompte',
            'discoveries_overdrafts' => 'Découvertes / Facilités de caisse',
            'spots_relay' => 'Spots / Relais',
            'campaign' => 'Campagne',
            'syndications' => 'Syndications',
        ],
        'job' => [
            'cdi' => 'CDI',
            'cdd' => 'CDD',
            'secondment' => 'Détachement / Mise en disponibilité',
            'trial_engagement' => 'Engagement à l\'essai',
            'academic_internship' => 'Stage académique',
            'professional_internship' => 'Stage professionnel',
        ],
        'warranty' => [
            'guarantees' => 'Garanties',
            'personal_sureties' => 'Sûretés personnelles',
            'real_estate_sureties' => 'Sûretés immobilières',
        ],
        'service' => [
            'supplier' => 'Fournisseur',
            'service_provider' => 'Prestataire',
        ],
    ];
}
