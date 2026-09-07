<?php

namespace App\Services;

use App\Http\Requests\DocumentRequest;
use App\Models\Document;
use App\Models\DocumentHistory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


/**
 * ==========================================================================
 * Servicio de gestión documental.
 * ==========================================================================
 *
 * Centraliza toda la lógica de negocio relacionada con documentos
 * vehiculares.
 */
class DocumentService
{

    /**
     * Guarda un nuevo documento vehicular.
     *
     * La lógica será trasladada desde DocumentController.
     */
    public function store(
        DocumentRequest $request
    )
    {

        $vehicle = Auth::user()
            ->vehicles()
            ->findOrFail(
                $request->vehicle_id
            );


        /*
        |--------------------------------------------------------------------------
        | Carpeta física del documento
        |--------------------------------------------------------------------------
        */
        $file = $request->file('archivo');


        $folder =
            'documents/vehicles/'
            . $vehicle->uuid
            . '/'
            . strtolower(
                str_replace(
                    ' ',
                    '_',
                    $request->tipo_documento
                )
            );


        $path = $file->store(
            $folder,
            'public'
        );


        /*
        |--------------------------------------------------------------------------
        | Registro en base de datos
        |--------------------------------------------------------------------------
        */
        $document = Document::create([

            'vehicle_id'        => $vehicle->id,

            'tipo_documento'    => $request->tipo_documento,

            'nombre'            => $request->nombre,

            'archivo'           => $path,

            'fecha_emision'     => $request->fecha_emision,

            'fecha_vencimiento' => $request->fecha_vencimiento,

            'observacion'       => $request->observacion

        ]);


        /*
        |--------------------------------------------------------------------------
        | Historial inicial del documento
        |--------------------------------------------------------------------------
        */

        DocumentHistory::create([

            'document_id' =>
                $document->id,

            'created_by' =>
                Auth::id(),

            'version' =>
                1,

            'accion' =>
                'creacion',

            'tipo_documento' =>
                $document->tipo_documento,

            'nombre' =>
                $document->nombre,

            'archivo' =>
                $document->archivo,

            'fecha_emision' =>
                $document->fecha_emision,

            'fecha_vencimiento' =>
                $document->fecha_vencimiento,

            'observacion' =>
                $document->observacion,

        ]);


        return $document;

    }

    /**
     * --------------------------------------------------------------------------
     * Actualiza un documento existente.
     * --------------------------------------------------------------------------
     *
     * Gestiona cambios de información documental y reemplazo opcional
     * del archivo asociado.
     */
    public function update(
        DocumentRequest $request,
        Document $document
    )
    {

        \Log::info('ENTRO DocumentService update', [
            'document_id' => $document->id
        ]);

        \Log::info('ENTRO DocumentService update');

        $data = [

            'tipo_documento' =>
                $request->tipo_documento,

            'nombre' =>
                $request->nombre,

            'fecha_emision' =>
                $request->fecha_emision ?? $document->fecha_emision,

            'fecha_vencimiento' =>
                $request->fecha_vencimiento ?? $document->fecha_vencimiento,

            'observacion' =>
                $request->observacion ?? $document->observacion,

        ];



        /*
        |--------------------------------------------------------------------------
        | Reemplazo opcional del archivo
        |--------------------------------------------------------------------------
        */

        if (
            $request->hasFile('archivo')
        ) {


            $oldFile =
                $document->archivo;



            $folder =
                'documents/vehicles/'
                . $document->vehicle->uuid
                . '/'
                . strtolower(
                    str_replace(
                        ' ',
                        '_',
                        $request->tipo_documento
                    )
                );



            $path =
                $request->file('archivo')
                ->store(
                    $folder,
                    'public'
                );


            $data['archivo'] =
                $path;



        }



        /*
        |--------------------------------------------------------------------------
        | Guarda historial de versión anterior
        |--------------------------------------------------------------------------
        */

        DocumentHistory::create([

            'document_id' =>
                $document->id,

            'created_by' =>
                Auth::id(),

            'version' =>
                ($document->histories()->max('version') ?? 0) + 1,

            'accion' =>
                isset($oldFile)
                    ? 'reemplazo'
                    : 'edicion',

            'tipo_documento' =>
                $document->tipo_documento,

            'nombre' =>
                $document->nombre,

            'archivo' =>
                $document->archivo,

            'fecha_emision' =>
                $document->fecha_emision,

            'fecha_vencimiento' =>
                $document->fecha_vencimiento,

            'observacion' =>
                $document->observacion,

        ]);



        $document->update(
            $data
        );



        if (
            isset($oldFile)
        ) {

            Storage::disk('local')
                ->delete(
                    $oldFile
                );

        }



        return $document;

    }


    /**
     * --------------------------------------------------------------------------
     * Elimina un documento existente.
     * --------------------------------------------------------------------------
     *
     * Gestiona eliminación del archivo físico y registro documental.
     */
    public function destroy(
        Document $document
    )
    {


        /*
        |--------------------------------------------------------------------------
        | Archivado lógico del documento
        |--------------------------------------------------------------------------
        |
        | Mantiene archivo físico e historial.
        | Solo marca deleted_at mediante SoftDeletes.
        |--------------------------------------------------------------------------
        */

        $document->delete();



        return true;

    }


}
