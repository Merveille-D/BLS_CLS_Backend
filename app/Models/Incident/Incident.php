<?php

namespace App\Models\Incident;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incident extends Model
{
    use HasFactory, HasUuids;

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
    ];

    const TYPES = [
        'avis-tiers-detenteurs',
        'requisition',
        'saisie-conservatoire',
        'saisie-attribution',
    ];

    const TYPE_VALUES = [
        'avis-tiers-detenteurs' => 'Avis à Tiers Détenteurs',
        'requisition' => 'Réquisition',
        'saisie-conservatoire' => 'Saisie Conservatoire',
        'saisie-attribution' => 'Saisie Attribution',
    ];

    public function taskIncident()
    {
        return $this->hasMany(TaskIncident::class)->map(function ($taskIncident) {
            $taskIncident->deadline = $taskIncident->date ?? $taskIncident->deadline;
            return $taskIncident;
        });;
    }

    public function authorIncident()
    {
        return $this->belongsTo(AuthorIncident::class,'author_incident_id');
    }

    public function getCurrentTaskAttribute() {

        $current_task_incident = $this->taskIncident->where('status', false)->first();
        return $current_task_incident;
    }

    public function getCategoryAttribute() {

        $value = $this->type;
        $label = self::TYPE_VALUES[$value];

        return [
            'value' => $value,
            'label' => $label,
        ];
    }

    public function getFilesAttribute() {

        $files = [];

        foreach ($this->taskIncident as $taskIncident) {
            foreach ($taskIncident->fileUploads as $fileUpload) {
                $files[] = [
                    'filename' => $fileUpload->name ?? null,
                    'file_url' => $fileUpload->file,
                ];
            }
        }
        return $files;
    }
}
