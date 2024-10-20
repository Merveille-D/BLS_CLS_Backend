<?php

namespace App\Models\Contract;

use App\Concerns\Traits\Alert\Alertable;
use App\Concerns\Traits\Transfer\Transferable;
use App\Models\Scopes\CountryScope;
use App\Models\Transfer\TransferDocument;
use App\Models\User;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
#[ScopedBy([CountryScope::class])]
class Contract extends Model
{
    use HasFactory, HasUuids, Alertable, Transferable;

    protected $fillable = [
        'title',
        'contract_category_id',
        'contract_type_category_id',
        'contract_sub_type_category_id',
        'date_signature',
        'date_effective',
        'date_expiration',
        'date_renewal',
        'status',
        'created_by',
        'contract_reference',
        'reference',
    ];

    const STATUS = [
        'initiated',
        'revised',
        'finalized',
        'classified',
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

        $total_transfers = array_merge($other_transfers, $transfers);

        return $total_transfers;
    }

    public function contractParts()
    {
        return $this->hasMany(ContractPart::class);
    }

    public function contractCategory()
    {
        return $this->belongsTo(ContractCategory::class);
    }

    public function contractTypeCategory()
    {
        return $this->belongsTo(ContractTypeCategory::class);
    }

    public function contractSubTypeCategory()
    {
        return $this->belongsTo(ContractSubTypeCategory::class);
    }

    public function getFirstPartAttribute() {

        $parts = $this->contractParts()->get();

        $part1 = [];

        foreach ($parts as $part) {
            if ($part->type === 'part_1') {
                $part1[] = [
                    'description' => $part->description,
                    'part_id' => $part->part_id,
                    'part' => $part->part,
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
                    'part' => $part->part,
                ];
            }
        }
        return $part2;
    }

    public function creator() {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function tasks() {
        return $this->hasMany(Task::class);
    }
}
