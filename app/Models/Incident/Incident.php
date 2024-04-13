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

    public function authorIncident()
    {
        return $this->belongsTo(AuthorIncident::class);
    }
}
