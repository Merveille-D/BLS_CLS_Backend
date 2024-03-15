<?php

namespace App\Models\Guarantee\ConventionnalHypothecs;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HypothecFile extends Model
{
    use HasFactory;


    /**
     * @property int $id
     * @property string $name
     */
    protected $fillable = array(
        'name',
        'file',
        'hypothec_step_id',
        'conventionnal_hypothec_id'
    );


    public function hypothecStep()
    {
        return $this->belongsTo(HypothecStep::class);
    }

    public function conventionnalHypothec()
    {
        return $this->belongsTo(ConventionnalHypothec::class);
    }
}
