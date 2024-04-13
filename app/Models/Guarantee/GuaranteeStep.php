<?php

namespace App\Models\Guarantee;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuaranteeStep extends Model
{
    use HasFactory;

    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = ['conv_hypothec_id', 'stepable_type', 'stepable_id'];

    public function hypothec()
    {
        return $this->belongsTo(ConvHypothec::class, 'conv_hypothec_id');
    }

    public function stepable()
    {
        return $this->morphTo();
    }
}
