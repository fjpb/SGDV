<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentAuditLog extends Model
{

    protected $fillable = [

        'document_id',

        'user_id',

        'accion',

        'datos_anteriores',

        'datos_nuevos',

        'ip_address',

        'user_agent',

    ];


    protected $casts = [

        'datos_anteriores' => 'array',

        'datos_nuevos' => 'array',

    ];


    /**
     * Documento asociado al evento.
     */
    public function document()
    {

        return $this->belongsTo(
            Document::class
        );

    }


    /**
     * Usuario que ejecutó la acción.
     */
    public function user()
    {

        return $this->belongsTo(
            User::class
        );

    }

}
