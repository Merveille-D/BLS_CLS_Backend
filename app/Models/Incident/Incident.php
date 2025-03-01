<?php

namespace App\Models\Incident;

use App\Http\Resources\Incident\TaskIncidentResource;
use App\Models\Scopes\CountryScope;
use App\Models\User;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ScopedBy([CountryScope::class])]
class Incident extends Model
{
    use HasFactory, HasUuids;

    const TYPES = [
        'avis-tiers-detenteurs',
        'requisition',
        'saisie-conservatoire',
        'saisie-attribution',
    ];

    const TYPE_VALUES = [
        'avis-tiers-detenteurs' => 'incident.atd',
        'requisition' => 'incident.req',
        'saisie-conservatoire' => 'incident.sc',
        'saisie-attribution' => 'incident.sa',
    ];

    const TYPE_CODES = [
        'avis-tiers-detenteurs' => 'ATD',
        'requisition' => 'REQ',
        'saisie-conservatoire' => 'SC',
        'saisie-attribution' => 'SA',
    ];

    /**
     * Les attributs qui doivent être castés vers des types natifs.
     *
     * @var array
     */
    protected $casts = [
        'client' => 'boolean',
        'status' => 'boolean',
    ];

    protected $fillable = [
        'title',
        'date_received',
        'type',
        'author_incident_id',
        'user_id',
        'client',
        'status',
        'created_by',
        'reference',
        'incident_reference',
    ];

    public function fileUploads()
    {
        return $this->morphMany(IncidentDocument::class, 'uploadable');
    }

    public function taskIncident()
    {
        return $this->hasMany(TaskIncident::class);
    }

    public function authorIncident()
    {
        return $this->belongsTo(AuthorIncident::class, 'author_incident_id');
    }

    public function getCurrentTaskAttribute()
    {

        $current_task_incident = $this->taskIncident->where('status', false)->first();

        return new TaskIncidentResource($current_task_incident);
    }

    public function getCategoryAttribute()
    {

        $value = $this->type;
        $label = __(self::TYPE_VALUES[$value]);

        return [
            'value' => $value,
            'label' => $label,
        ];
    }

    public function getFilesAttribute()
    {

        $files = [];

        foreach ($this->taskIncident as $taskIncident) {
            foreach ($taskIncident->fileUploads as $fileUpload) {
                $files[] = [
                    'filename' => $fileUpload->name ?? null,
                    'file_url' => $fileUpload->file,
                ];
            }
        }

        foreach ($this->fileUploads as $fileUpload) {
            $files[] = [
                'filename' => $fileUpload->name ?? null,
                'file_url' => $fileUpload->file,
            ];
        }

        return $files;
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
