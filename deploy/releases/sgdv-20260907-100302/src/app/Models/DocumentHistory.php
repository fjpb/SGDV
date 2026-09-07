<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DocumentHistory extends Model
{

    /**
     * Campos permitidos para asignación masiva.
     */
    protected $fillable = [

        'document_id',

        'created_by',

        'version',

        'accion',

        'tipo_documento',

        'nombre',

        'archivo',

        'fecha_emision',

        'fecha_vencimiento',

        'observacion',

    ];



    /**
     * Historial pertenece a un documento.
     */
    public function document(): BelongsTo
    {

        return $this->belongsTo(
            Document::class
        );

    }



    /**
     * Historial creado por un usuario.
     */
    public function creator(): BelongsTo
    {

        return $this->belongsTo(
            User::class,
            'created_by'
        );

    }

}
