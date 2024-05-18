<?php

namespace App\Models\Contract;

use App\Concerns\Traits\Alert\Alertable;
use App\Concerns\Traits\Transfer\Transferable;
use App\Models\Transfer\TransferDocument;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory, HasUuids, Alertable, Transferable;

    protected $fillable = [
        'title',
        'category',
        'type_category',
        'date_signature',
        'date_effective',
        'date_expiration',
        'date_renewal',
        'status',
    ];

    const CATEGORIES = [
        'leases',
        'credits',
        'jobs',
        'warranties',
        'services',
    ];

    const STATUS = [
        'initiated',
        'revised',
        'finalized',
        'classified',
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

    public function fileUploads()
    {
        return $this->morphMany(ContractDocument::class, 'uploadable');
    }

    public function getDocumentsAttribute()
    {
        $transfers = [];

        $transfers[] = [
            'step_name' => "Initiation",
            'files' => $this->fileUploads->map(function ($fileUpload) {
                return [
                    'filename' => $fileUpload->name ?? null,
                    'file_url' => $fileUpload->file,
                    'type' => 'other',
                ];
            }),
        ];
        $other_transfers = [];

        foreach ($this->transfers as $transfer) {
            $other_transfers[] = [
                'step_name' => $transfer->title,
                'files' => $transfer->fileTransfers->map(function ($fileTransfer) {
                    return [
                        'filename' => $fileTransfer->name ?? null,
                        'file_url' => $fileTransfer->file,
                        'type' => 'other',
                    ];
                }),
            ];
        }

        $total_transfers = array_merge($transfers, $other_transfers);

        return $total_transfers;
    }

    public function contractParts()
    {
        return $this->hasMany(ContractPart::class);
    }

    public function getInfoCategoryAttribute()
    {
        $value = $this->category;
        $label = self::CATEGORIES_VALUES[$value];

        return [
            'value' => $value,
            'label' => $label,
        ];
    }

    public function getInfoTypeCategoryAttribute()
    {
        $value = $this->getAttribute('type_category');

        $label = ($this->category != 'leases') ? self::TYPE_CATEGORIES_VALUES[$this->category][$value] : "";

        return [
            'value' => $value,
            'label' => $label,
        ];
    }

    public function getFirstPartAttribute() {

        $parts = $this->contractParts()->get();

        $part1 = [];

        foreach ($parts as $part) {
            if ($part->type === 'part_1') {
                $part1[] = [
                    'description' => $part->description,
                    'part_id' => $part->part_id,
                ];
            }
        }

        return $part1;
    }


    public function getSecondPartAttribute() {

        $parts = $this->contractParts()->get();

        $part2 = [];

        foreach ($parts as $part) {
            if ($part->type === 'part_2') {
                $part2[] = [
                    'description' => $part->description,
                    'part_id' => $part->part_id,
                ];
            }
        }
        return $part2;
    }
}
