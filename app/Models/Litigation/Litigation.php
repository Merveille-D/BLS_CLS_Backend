<?php

namespace App\Models\Litigation;

use App\Models\ModuleTask;
use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Litigation extends Model
{
    use HasFactory,  HasUuids, SoftDeletes;

    protected $fillable = [
        'name', 'nature_id', 'party_id', 'jurisdiction_id', 'reference', 'nature_id', 'jurisdiction_id', 'party_id', 'lawyer_id', 'jurisdiction_id', 'user_id',
        'estimated_amount', 'added_amount', 'remaining_amount', 'is_archived', 'jurisdiction_location',
        'created_by', 'extra', 'number'
    ];

    protected $casts = [
        'added_amount' => 'array',
        'extra' => 'array',
        'is_archived' => 'boolean',
    ];


    /**
     * documents
     *
     * @return MorphMany
     */
    public function documents() : MorphMany
    {
        return $this->morphMany(LitigationDocument::class, 'documentable');
    }

    /**
     * nature
     *
     * @return HasOne
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
    public function lawyers() : MorphToMany
    {
        return $this->morphedByMany(LitigationLawyer::class, 'litigationable');
    }

    public function parties() : MorphToMany
    {
        return $this->morphedByMany(LitigationParty::class, 'litigationable')
                    ->withPivot('category', 'type')
                    ;
    }

    public function users() : MorphToMany
    {
        return $this->morphedByMany(User::class, 'litigationable');
    }

    public function tasks() {
        return $this->morphMany(LitigationTask::class, 'taskable');
    }

    public function getNextTaskAttribute() {
        return $this->tasks()
                ->orderByRaw('IF(max_deadline IS NOT NULL, 0, 1)')
                ->orderBy('max_deadline')
                ->orderBy('rank')
                ->where('status', false)->first();
    }

    public function getCurrentTaskAttribute() {
        return $this->tasks()
                    ->orderByRaw('IF(max_deadline IS NOT NULL, 0, 1)')
                    ->orderByDesc('max_deadline')
                    ->orderByDesc('rank')
                    ->where('status', true)
                    ->first();
    }

}
