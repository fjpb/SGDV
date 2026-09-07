<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PublicVehicleView extends Model
{

    protected $fillable = [
        'vehicle_id',
        'document_id',
        'ip',
        'user_agent',
        'accion'
    ];


    /**
     * Vehículo consultado públicamente
     */
    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }


    /**
     * Documento visualizado públicamente
     */
    public function document(): BelongsTo
    {
        return $this->belongsTo(Document::class);
    }

}
