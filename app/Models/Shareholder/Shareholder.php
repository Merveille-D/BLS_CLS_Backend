<?php

namespace App\Models\Shareholder;

use App\Models\Scopes\CountryScope;
use App\Models\User;
use App\Observers\ShareholderObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
#[ScopedBy([CountryScope::class])]
#[ObservedBy([ShareholderObserver::class])]
class Shareholder extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'name',
        'type',
        'nationality',
        'address',
        'corporate_type',
        'actions_number',
        'actions_encumbered',
        'actions_no_encumbered',
        'percentage',
        'created_by',
    ];

    const TYPES = [
        'individual',
        'corporate',
    ];

    const CORPORATE_TYPES = [
        'company',
        'institution',
    ];

    public function creator() {
        return $this->belongsTo(User::class, 'created_by');
    }
}
