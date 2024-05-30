<?php

namespace App\Models\Evaluation;

use App\Models\Scopes\CountryScope;
use App\Models\User;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
#[ScopedBy([CountryScope::class])]
class Collaborator extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'lastname',
        'firstname',
        'user_id',
        'performance_indicator_id',
        'position',
        'created_by',
    ];

    public function performanceIndicator()
    {
        return $this->belongsTo(PerformanceIndicator::class);
    }

    public function creator() {
        return $this->belongsTo(User::class, 'created_by');
    }
}
