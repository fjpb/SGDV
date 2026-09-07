<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Support\Facades\Storage;

class PublicDocumentController extends Controller
{


    /**
     * Visualización pública de documento PDF
     * desde visor fiscalizador
     */
    public function view($uuid)
    {


        $document = Document::where(
            'uuid',
            $uuid
        )
        ->firstOrFail();



        if(
            !Storage::exists(
                $document->archivo
            )
        ){

            abort(404);

        }



        return response()->file(

            Storage::path(
                $document->archivo
            )

        );


    }


}
