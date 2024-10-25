<?php

namespace App\Models\Shareholder;

use App\Models\Gourvernance\GourvernanceDocument;
use App\Models\Gourvernance\Tier;
use App\Models\Scopes\CountryScope;
use App\Models\User;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ScopedBy([CountryScope::class])]
class ActionTransfer extends Model
{
    use HasFactory, HasUuids;

    const STATUS = ['pending', 'rejected', 'cancelled', 'validated', 'approved'];

    const TYPES = ['shareholder', 'tier'];

    const TYPE_VALUES = [
        'shareholder' => 'Actionnaire vers Actionnaire',
        'tier' => 'Actionnaire vers Tiers',
    ];

    protected $fillable = [
        'owner_id',
        'buyer_id',
        'tier_id',
        'type',
        'count_actions',
        'status',
        'transfer_date',
        'transfer_id',
        'reference',
        'created_by',
    ];

    public function fileUploads()
    {
        return $this->morphMany(GourvernanceDocument::class, 'uploadable');
    }

    public function getCategoryAttribute()
    {

        $value = $this->type;
        $label = self::TYPE_VALUES[$value];

        return [
            'value' => $value,
            'label' => $label,
        ];
    }

    public function taskActionTransfers()
    {
        return $this->hasMany(TaskActionTransfer::class);
    }

    public function getCurrentTaskAttribute()
    {

        $current_task_action_transfer = $this->taskActionTransfers->where('status', false)->first();

        return $current_task_action_transfer;
    }

    public function getFilesAttribute()
    {

        $files = [];

        foreach ($this->taskActionTransfers as $taskActionTransfers) {
            foreach ($taskActionTransfers->fileUploads as $fileUpload) {
                $files[] = [
                    'filename' => $fileUpload->name ?? null,
                    'file_url' => $fileUpload->file,
                ];
            }
        }

        return $files;
    }

    public function owner()
    {
        return $this->belongsTo(Shareholder::class, 'owner_id');
    }

    public function shareholder()
    {
        return $this->belongsTo(Shareholder::class, 'buyer_id');
    }

    public function tier()
    {
        return $this->belongsTo(Tier::class, 'tier_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
