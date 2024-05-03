<?php

namespace App\Models\Litigation;

use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Litigation extends Model
{
    use HasFactory,  HasUuids;

    protected $fillable = [
        'name', 'nature_id', 'party_id', 'jurisdiction_id', 'reference', 'nature_id', 'jurisdiction_id', 'party_id', 'lawyer_id', 'jurisdiction_id', 'user_id',
        'estimated_amount', 'added_amount', 'remaining_amount', 'is_archived', 'jurisdiction_location'
    ];

    protected $casts = [
        'added_amount' => 'array'
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

    public function tasks() : MorphMany
    {
        return $this->morphMany(LitigationTask::class, 'taskable');
    }

}
