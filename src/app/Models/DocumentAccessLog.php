<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DocumentAccessLog extends Model
{

    /**
     * Campos asignables.
     */
    protected $fillable = [

        'document_id',

        'user_id',

        'accion',

        'ip_address',

        'user_agent',

    ];


    /**
     * Documento asociado.
     */
    public function document(): BelongsTo
    {

        return $this->belongsTo(
            Document::class
        );

    }


    /**
     * Usuario que realizó la acción.
     */
    public function user(): BelongsTo
    {

        return $this->belongsTo(
            User::class
        );

    }

}
