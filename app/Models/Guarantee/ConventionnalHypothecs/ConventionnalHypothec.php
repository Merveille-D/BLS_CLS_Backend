<?php

namespace App\Models\Guarantee\ConventionnalHypothecs;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConventionnalHypothec extends Model
{
    use HasFactory;

    /**
     * @property int $id
     * @property string $name
     * @property bool $is_verified
     * @property bool $is_approved
     * @property string $date_sell
     * @property string $date_signification
     */
    protected $fillable = array(
        'name',
        'is_verified',
        'date_subscribed',
        'is_subscribed',
        'is_approved',
        'date_signification',
        'type_actor',
        'is_significated',
        'date_sell',
        'date_deposit_specification',
        'is_publied',
        'sell_price_estate',
    );
}
