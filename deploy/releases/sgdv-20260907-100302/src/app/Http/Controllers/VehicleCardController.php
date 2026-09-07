<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Carbon\Carbon;

class VehicleCardController extends Controller
{


    /**
     * Tarjeta imprimible del vehículo
     */
    public function show(Vehicle $vehicle)
    {

        $this->authorize('view', $vehicle);


        $url = route(
            'public.vehicle',
            $vehicle->uuid
        );


        $qr = QrCode::size(250)
            ->generate($url);


        $cumplimiento = $vehicle->porcentajeDocumentacion();


        $totalDocumentos = $vehicle->totalDocumentos();


        $vigentes = $vehicle->documentosVigentes();


        if ($cumplimiento >= 80) {

            $estadoGeneral = 'Documentación al día';

        } elseif ($cumplimiento >= 50) {

            $estadoGeneral = 'Revisión requerida';

        } else {

            $estadoGeneral = 'Atención requerida';

        }


        $fechaGeneracion = Carbon::now()
            ->format('d-m-Y H:i');


        return view(
            'vehicles.card',
            compact(
                'vehicle',
                'qr',
                'url',
                'cumplimiento',
                'totalDocumentos',
                'vigentes',
                'estadoGeneral',
                'fechaGeneracion'
            )
        );

    }
}
