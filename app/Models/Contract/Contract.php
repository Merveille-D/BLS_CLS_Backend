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
        'leases' => [

        ],
        'credits' => [
            'amortizable',
            'aval_discount',
            'discoveries_ovecouvertes',
            'spots_relay',
            'campaign',
            'syndications',
        ],
        'jobs' => [
            'cdi',
            'cdd',
            'secondment',
            'trial_engagement',
            'academic_internship',
            'professional_internship',
        ],
        'warranties' => [
            'guarantees',
            'personal_sureties',
            'real_estate_sureties',
        ],
        'services' => [
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
        'leases' => [],
        'credits' => [
            'amortizable' => 'Amortissable',
            'aval_discount' => 'Aval / Escompte',
            'discoveries_overdrafts' => 'Découvertes / Facilités de caisse',
            'spots_relay' => 'Spots / Relais',
            'campaign' => 'Campagne',
            'syndications' => 'Syndications',
        ],
        'jobs' => [
            'cdi' => 'CDI',
            'cdd' => 'CDD',
            'secondment' => 'Détachement / Mise en disponibilité',
            'trial_engagement' => 'Engagement à l\'essai',
            'academic_internship' => 'Stage académique',
            'professional_internship' => 'Stage professionnel',
        ],
        'warranties' => [
            'guarantees' => 'Garanties',
            'personal_sureties' => 'Sûretés personnelles',
            'real_estate_sureties' => 'Sûretés immobilières',
        ],
        'services' => [
            'supplier' => 'Fournisseur',
            'service_provider' => 'Prestataire',
        ],
    ];
}
