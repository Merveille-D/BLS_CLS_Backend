<?php

namespace App\Models\Litigation;

use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Litigation extends Model
{
    use HasFactory,  HasUuids;

    protected $fillable = [
        'name', 'nature_id', 'party_id', 'jurisdiction_id', 'reference', 'nature_id', 'jurisdiction_id', 'party_id', 'lawyer_id', 'jurisdiction_id', 'user_id',
        'estimated_amount', 'added_amount', 'remaining_amount'
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
     * party
     *
     * @return void
     */
    public function party()
    {
        return $this->hasOne(LitigationParty::class, 'id', 'party_id');
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
    public function lawyer()
    {
        return $this->hasOne(LitigationLawyer::class, 'id', 'lawyer_id');
    }
}
