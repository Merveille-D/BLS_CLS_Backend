<?php

namespace App\Models\Guarantee\ConventionnalHypothecs;

use App\Concerns\Traits\Alert\Alertable;
use App\Models\Alert\Alert;
use App\Models\Guarantee\GuaranteeDocument;
use App\Observers\ConvHypothecObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Notifications\Notifiable;

#[ObservedBy([ConvHypothecObserver::class])]
class ConventionnalHypothec extends Model
{
    use HasFactory, Alertable, HasUuids;

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
        'contract_file',
        'state',
        'step',
        'reference',
        'contract_id',
        'registration_date',
        'registering_date',
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

    /**
     * documents
     *
     * @return MorphMany
     */
    public function documents() : MorphMany
    {
        return $this->morphMany(GuaranteeDocument::class, 'documentable');
    }

}
