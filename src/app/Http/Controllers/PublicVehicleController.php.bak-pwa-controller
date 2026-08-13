<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\Document;
use App\Models\PublicVehicleView;

class PublicVehicleController extends Controller
{

    /**
     * Consulta pública vehículo mediante QR
     */
    public function show($token)
    {

        $vehicle = Vehicle::where(
            'uuid',
            $token
        )
        ->with('documents')
        ->firstOrFail();



        PublicVehicleView::create([

            'vehicle_id' => $vehicle->id,

            'document_id' => null,

            'ip' => request()->ip(),

            'user_agent' => request()->userAgent(),

            'accion' => 'consulta_qr'

        ]);



        return view(
            'public.vehicle',
            compact('vehicle')
        );

    }




    /**
     * Visualización PDF pública inline
     */
    public function document($uuid)
    {

        $document = Document::where(
            'uuid',
            $uuid
        )
        ->firstOrFail();



        if (!\Storage::disk('public')->exists($document->archivo)) {

            abort(404);

        }



        PublicVehicleView::create([

            'vehicle_id' => $document->vehicle_id,

            'document_id' => $document->id,

            'ip' => request()->ip(),

            'user_agent' => request()->userAgent(),

            'accion' => 'visualizacion_pdf'

        ]);



        return response()->file(
            storage_path(
                'app/public/'.$document->archivo
            )
        );

    }

}
