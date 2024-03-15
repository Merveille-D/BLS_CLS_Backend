<?php

namespace App\Models\Gourvernance\BoardDirectors\Administrators;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaProcedure extends Model
{
    use HasFactory;

    /**
     * Class CaProcedure
     *
     * @property int $id Primary
     * @property date $send_date Primary
     *
     * @package App\Models
     */

    protected $fillable = [
        'send_date',
        'document_name',
        'ca_administrator_id',
        'ca_type_document_id',
    ];

    public function caAdministrator()
    {
        return $this->belongsTo(CaAdministrator::class);
    }

    public function caTypeDocument()
    {
        return $this->belongsTo(CaTypeDocument::class);
    }
}
