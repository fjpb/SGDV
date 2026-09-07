<?php

namespace App\Services;

use App\Models\DocumentAccessLog;
use Illuminate\Support\Facades\Auth;

class AuditService
{

    /**
     * Registra una acción sobre un documento.
     */
    public function document(
        int $documentId,
        string $accion
    )
    {

        return DocumentAccessLog::create([

            'document_id' => $documentId,

            'user_id' => Auth::id(),

            'accion' => $accion,

            'ip_address' => request()->ip(),

            'user_agent' => request()->userAgent(),

        ]);

    }

}
