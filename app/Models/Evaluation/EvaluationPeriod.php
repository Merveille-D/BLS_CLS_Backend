<?php

namespace App\Models\Evaluation;

use App\Concerns\Traits\Alert\Alertable;
use App\Models\Scopes\CountryScope;
use App\Models\User;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ScopedBy([CountryScope::class])]
class EvaluationPeriod extends Model
{
    use Alertable, HasFactory, HasUuids;

    protected $fillable = [
        'title',
        'deadline',
        'status',
        'created_by',
        'completed_by',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getValidationAttribute()
    {

        return [
            'method' => 'PUT',
            'action' => config('app.url') . '/api/evaluation_periods/' . $this->id,
        ];
    }
}
