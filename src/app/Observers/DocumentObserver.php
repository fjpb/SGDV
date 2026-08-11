<?php

namespace App\Observers;

use App\Models\Document;
use App\Models\DocumentAuditLog;
use Illuminate\Support\Facades\Auth;

class DocumentObserver
{

    /**
     * Documento creado.
     */
    public function created(Document $document): void
    {

        \Log::info('OBSERVER DOCUMENT CREATED EJECUTADO', [
            'document_id' => $document->id
        ]);

        DocumentAuditLog::create([

            'document_id' => $document->id,

            'user_id' => Auth::id() ?? 1,

            'accion' => 'creacion',

            'datos_nuevos' => [

                'tipo_documento' => $document->tipo_documento,

                'nombre' => $document->nombre,

                'archivo' => $document->archivo,

                'fecha_emision' => $document->fecha_emision,

                'fecha_vencimiento' => $document->fecha_vencimiento,

            ],

            'ip_address' => request()->ip(),

            'user_agent' => request()->userAgent(),

        ]);

    }


    /**
     * Documento actualizado.
     */
    public function updated(Document $document): void
    {

        /*
        |--------------------------------------------------------------------------
        | Evita registrar restauraciones como ediciones.
        |--------------------------------------------------------------------------
        */

        if (
            array_key_exists(
                'deleted_at',
                $document->getChanges()
            )
        ) {

            return;

        }


        DocumentAuditLog::create([

            'document_id' => $document->id,

            'user_id' => Auth::id() ?? 1,

            'accion' => 'edicion',

            'datos_nuevos' => $document->getChanges(),

            'datos_anteriores' => $document->getOriginal(),

            'ip_address' => request()->ip(),

            'user_agent' => request()->userAgent(),

        ]);

    }


    /**
     * Documento eliminado.
     */
    public function deleted(Document $document): void
    {

        DocumentAuditLog::create([

            'document_id' => $document->id,

            'user_id' => Auth::id() ?? 1,

            'accion' => 'eliminacion',

            'datos_anteriores' => $document->toArray(),

            'ip_address' => request()->ip(),

            'user_agent' => request()->userAgent(),

        ]);

    }


    /**
     * Documento restaurado desde archivado.
     */
    public function restored(Document $document): void
    {

        DocumentAuditLog::create([

            'document_id' => $document->id,

            'user_id' => Auth::id() ?? 1,

            'accion' => 'restauracion',

            'datos_nuevos' => $document->toArray(),

            'ip_address' => request()->ip(),

            'user_agent' => request()->userAgent(),

        ]);

    }


}
