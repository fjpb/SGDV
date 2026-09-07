<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Vehicle;
use App\Models\DocumentAccessLog;
use App\Http\Requests\DocumentRequest;
use App\Services\DocumentService;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class DocumentController extends Controller
{

    protected DocumentService $documentService;


    public function __construct(
        DocumentService $documentService
    )
    {
        $this->documentService = $documentService;
    }


    /**
     * --------------------------------------------------------------------------
     * Listado general de documentos del usuario autenticado.
     * --------------------------------------------------------------------------
     */
    public function index()
    {
        $this->authorize('viewAny', Document::class);


        $documents = Document::whereHas(
            'vehicle',
            function ($query) {

                $query->where(
                    'user_id',
                    Auth::id()
                );

            }
        )
        ->latest()
        ->get();

        return view(
            'documents.index',
            compact('documents')
        );

    }


    /**
     * --------------------------------------------------------------------------
     * Formulario para crear un documento.
     * --------------------------------------------------------------------------
     */
    public function create(Request $request)
    {
        $this->authorize('create', Document::class);


        $vehicles = Auth::user()
            ->vehicles()
            ->where('estado', 'activo')
            ->get();


        $documentTypes = \App\Models\DocumentType::where(
            'activo',
            true
        )
        ->orderBy('nombre')
        ->get();



        return view(
            'documents.create',
            compact(
                'vehicles',
                'documentTypes'
            )
        )->with(
            'selectedVehicle',
            $request->vehicle
        );

    }


    /**
     * --------------------------------------------------------------------------
     * Guarda un nuevo documento.
     * --------------------------------------------------------------------------
     */
    public function store(
        DocumentRequest $request
    )
    {
        $this->authorize('create', Document::class);


        $this->documentService->store(
            $request
        );


        return redirect()

            ->route('documents.index')

            ->with(
                'success',
                'Documento cargado correctamente.'
            );

    }


    /**
     * --------------------------------------------------------------------------
     * Actualiza un documento existente.
     * --------------------------------------------------------------------------
     */
    public function update(
        DocumentRequest $request,
        Document $document
    )
    {

        $this->authorize(
            'update',
            $document
        );


        $this->documentService->update(
            $request,
            $document
        );


        return redirect()

            ->route(
                'documents.show',
                $document
            )

            ->with(
                'success',
                'Documento actualizado correctamente.'
            );

    }


    /**
     * --------------------------------------------------------------------------
     * Formulario para editar un documento existente.
     * --------------------------------------------------------------------------
     */
    public function edit(
        Document $document
    )
    {

        $this->authorize(
            'update',
            $document
        );


        $documentTypes = \App\Models\DocumentType::where(
            'activo',
            true
        )
        ->orderBy('nombre')
        ->get();


        return view(
            'documents.edit',
            compact(
                'document',
                'documentTypes'
            )
        );

    }




    /**
     * --------------------------------------------------------------------------
     * Muestra la ficha del documento.
     * --------------------------------------------------------------------------
     */
    public function show(
        Document $document
    )
    {

        $this->authorize(
            'view',
            $document
        );

        $document->load([
            'histories' => function ($query) {
                $query->with('creator')
                      ->orderByDesc('version');
            },
            'auditLogs.user'
        ]);


        DocumentAccessLog::create([

            'document_id' => $document->id,

            'user_id' => Auth::id(),

            'accion' => 'visualizacion',

            'ip_address' => request()->ip(),

            'user_agent' => request()->userAgent(),

        ]);


        return view(
            'documents.show',
            compact('document')
        );

    }


    /**
     * --------------------------------------------------------------------------
     * Descarga el archivo físico del documento.
     * --------------------------------------------------------------------------
     */
    public function download(
        Document $document
    )
    {

        $this->authorize(
            'view',
            $document
        );

        DocumentAccessLog::create([

            'document_id' => $document->id,

            'user_id' => Auth::id(),

            'accion' => 'descarga',

            'ip_address' => request()->ip(),

            'user_agent' => request()->userAgent(),

        ]);


        return Storage::disk('public')
            ->download(
                $document->archivo
            );

    }


    /**
     * --------------------------------------------------------------------------
     * Elimina un documento.
     * --------------------------------------------------------------------------
     */
    public function destroy(
        Document $document
    )
    {

        $this->authorize(
            'delete',
            $document
        );


        $this->documentService->destroy(
            $document
        );


        return redirect()

            ->route('documents.index')

            ->with(
                'success',
                'Documento archivado correctamente.'
            );

    }


    /**
     * --------------------------------------------------------------------------
     * Lista los documentos asociados a un vehículo.
     * --------------------------------------------------------------------------
     */
    /**
     * --------------------------------------------------------------------------
     * Restaura una versión histórica del documento.
     * --------------------------------------------------------------------------
     */
    public function restore(
        \App\Models\DocumentHistory $history
    )
    {

        $document = $history->document;

        $document->load('vehicle');


        $this->authorize(
            'update',
            $document
        );


        \DB::transaction(function () use ($document, $history) {


            \App\Models\DocumentHistory::create([

                'document_id' => $document->id,

                'created_by' => Auth::id(),

                'version' =>
                    ($document->histories()->max('version') ?? 0) + 1,

                'accion' => 'restauracion',

                'tipo_documento' => $document->tipo_documento,

                'nombre' => $document->nombre,

                'archivo' => $document->archivo,

                'fecha_emision' => $document->fecha_emision,

                'fecha_vencimiento' => $document->fecha_vencimiento,

                'observacion' => $document->observacion,

            ]);


            $document->update([

                'tipo_documento' => $history->tipo_documento,

                'nombre' => $history->nombre,

                'archivo' => $history->archivo,

                'fecha_emision' => $history->fecha_emision,

                'fecha_vencimiento' => $history->fecha_vencimiento,

                'observacion' => $history->observacion,

            ]);

        });


        return redirect()

            ->route(
                'documents.show',
                $document
            )

            ->with(
                'success',
                'Versión restaurada correctamente.'
            );

    }



    /**
     * --------------------------------------------------------------------------
     * Lista documentos archivados.
     * --------------------------------------------------------------------------
     */
    public function trash()
    {
        $this->authorize('viewTrashed', Document::class);


        $documents = Document::onlyTrashed()
            ->with([
                'vehicle',
                'auditLogs.user'
            ])
            ->latest('deleted_at')
            ->get();


        return view(
            'documents.trash',
            compact('documents')
        );

    }



    /**
     * --------------------------------------------------------------------------
     * Restaura documento archivado.
     * --------------------------------------------------------------------------
     */
    public function restoreDeleted(
        $id
    )
    {

        $document = Document::onlyTrashed()
            ->findOrFail($id);


        $this->authorize(
            'restore',
            $document
        );


        \DB::transaction(function () use ($document) {

            $document->restore();

        });


        return redirect()

            ->route('documents.trash')

            ->with(
                'success',
                'Documento restaurado correctamente.'
            );

    }



    public function vehicleDocuments(Vehicle $vehicle)
    {
        $this->authorize('view', $vehicle);

        $documents = $vehicle->documents()->get();

        return view(
            'documents.vehicle',
            compact('documents')
        );

    }




}
