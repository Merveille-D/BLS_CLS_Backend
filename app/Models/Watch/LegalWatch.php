<?php

namespace App\Models\Watch;

use App\Models\Litigation\LitigationSetting;
use App\Models\Scopes\CountryScope;
use App\Models\User;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ScopedBy([CountryScope::class])]
class LegalWatch extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'name',
        'reference',
        'type',
        'summary',
        'innovation',
        'is_archived',
        'event_date',
        'effective_date',
        'nature_id',
        'jurisdiction_id',
        'recipient_type',
        'mail_object',
        'mail_content',
        'mail_addresses',
        'is_sent',
        'created_by',
        'jurisdiction_location',
        'case_number',
    ];

    protected $casts = [
        'mail_addresses' => 'array',
        'is_archived' => 'boolean',
        'is_sent' => 'boolean',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * nature
     *
     * @return void
     */
    public function nature()
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
}
