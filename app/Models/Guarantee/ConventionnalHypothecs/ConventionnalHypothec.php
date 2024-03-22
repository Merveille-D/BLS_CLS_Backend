<?php

namespace App\Models\Guarantee\ConventionnalHypothecs;

use App\Models\Guarantee\GuaranteeDocument;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

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

        'registration_accepted_proof_file',
        'registration_request_discharge_file',
        'signification_file',
        'agreement_file',
        'property_file',
    );

    /**
     * documents relationship
     * @return MorphMany
     */
    public function documents() : MorphMany
    {
        return $this->morphMany(GuaranteeDocument::class, 'documentable');
    }
}
