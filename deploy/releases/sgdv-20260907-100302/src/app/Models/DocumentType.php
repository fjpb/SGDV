<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


/**
 * Modelo catálogo tipos documentos
 */
class DocumentType extends Model
{


    protected $fillable = [

        'nombre',
        'descripcion',
        'activo'

    ];



    /**
     * Documentos asociados al tipo
     */
    public function documents()
    {

        return $this->hasMany(
            Document::class
        );

    }


}