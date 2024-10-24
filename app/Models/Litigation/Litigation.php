<?php

namespace App\Models\Litigation;

use App\Models\Scopes\CountryScope;
use App\Models\User;
use App\Observers\Litigation\LitigationObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[ScopedBy([CountryScope::class])]
#[ObservedBy([LitigationObserver::class])]
class Litigation extends Model
{
    use HasFactory,  HasUuids, SoftDeletes;

    protected $fillable = [
        'name', 'nature_id', 'party_id', 'jurisdiction_id', 'reference', 'nature_id', 'jurisdiction_id', 'party_id', 'lawyer_id', 'jurisdiction_id', 'user_id',
        'estimated_amount', 'added_amount', 'remaining_amount', 'is_archived', 'jurisdiction_location',
        'created_by', 'extra', 'case_number',
        'has_provisions',
    ];

    protected $casts = [
        'added_amount' => 'array',
        'extra' => 'array',
        'is_archived' => 'boolean',
        'has_provisions' => 'boolean',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * documents
     */
    public function documents(): MorphMany
    {
        return $this->morphMany(LitigationDocument::class, 'documentable');
    }

    /**
     * nature
     */
    public function nature(): HasOne
    {
        return $this->hasOne(LitigationSetting::class, 'id', 'nature_id');
    }

    /**
     * jurisdiction
     *
     * @return void
     */
    public function jurisdiction()
    {
        return $this->hasOne(LitigationSetting::class, 'id', 'jurisdiction_id');
    }

    /**
     * user
     *
     * @return void
     */
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    /**
     * lawyer
     *
     * @return void
     */
    public function lawyers(): MorphToMany
    {
        return $this->morphedByMany(LitigationLawyer::class, 'litigationable');
    }

    public function parties(): MorphToMany
    {
        return $this->morphedByMany(LitigationParty::class, 'litigationable')
            ->withPivot('category', 'type');
    }

    public function users(): MorphToMany
    {
        return $this->morphedByMany(User::class, 'litigationable');
    }

    public function tasks()
    {
        return $this->morphMany(LitigationTask::class, 'taskable');
    }

    public function getNextTaskAttribute()
    {
        return $this->tasks()
            ->orderByRaw('IF(max_deadline IS NOT NULL, 0, 1)')
            ->orderBy('max_deadline')
            ->orderBy('rank')
            ->where('status', false)->first();
    }

    public function getCurrentTaskAttribute()
    {
        return $this->tasks()
            ->orderByRaw('IF(max_deadline IS NOT NULL, 0, 1)')
            ->orderByDesc('max_deadline')
            ->orderByDesc('rank')
            ->where('status', true)
            ->first();
    }
}
