<?php

namespace App\Http\Controllers;

use App\Models\PublicVehicleView;
use App\Models\DocumentAuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class AuditController extends Controller
{

    public function index()
    {
        $this->authorize('viewAny', DocumentAuditLog::class);


        $totalEventos = DocumentAuditLog::count();


        $documentosAuditados = DocumentAuditLog::distinct(
            'document_id'
        )->count('document_id');


        $usuariosAuditados = DocumentAuditLog::distinct(
            'user_id'
        )->count('user_id');


        $ultimoEvento = DocumentAuditLog::latest()
            ->first();


        $ultimosEventos = DocumentAuditLog::with([
            'document',
            'user'
        ])
        ->latest()
        ->limit(10)
        ->get();


        return view(
            'audit.index',
            compact(
                'totalEventos',
                'documentosAuditados',
                'usuariosAuditados',
                'ultimoEvento',
                'ultimosEventos'
            )
        );

    }



    /**
     * Consultas públicas realizadas mediante QR
     */
    public function publicViews(Request $request)
    {
        $this->authorize('viewAny', PublicVehicleView::class);


        $query = PublicVehicleView::with([
            'vehicle',
            'document'
        ]);



        /*
        |--------------------------------------------------------------------------
        | Filtros
        |--------------------------------------------------------------------------
        */


        if ($request->filled('desde')) {

            $query->whereDate(
                'created_at',
                '>=',
                $request->desde
            );

        }


        if ($request->filled('hasta')) {

            $query->whereDate(
                'created_at',
                '<=',
                $request->hasta
            );

        }


        if ($request->filled('patente')) {

            $query->whereHas(
                'vehicle',
                function($q) use ($request){

                    $q->where(
                        'patente',
                        'like',
                        '%'.$request->patente.'%'
                    );

                }
            );

        }


        if ($request->filled('accion')) {

            $query->where(
                'accion',
                $request->accion
            );

        }



        $views = $query
            ->latest()
            ->paginate(20)
            ->withQueryString();



        /*
        |--------------------------------------------------------------------------
        | Indicadores globales filtrados
        |--------------------------------------------------------------------------
        */


        $base = clone $query;


        $totalConsultas = (clone $base)->count();


        $consultasHoy = (clone $base)
            ->whereDate(
                'created_at',
                Carbon::today()
            )
            ->count();


        $pdfVisualizados = (clone $base)
            ->where(
                'accion',
                'visualizacion_pdf'
            )
            ->count();


        $vehiculosConsultados = (clone $base)
            ->distinct('vehicle_id')
            ->count('vehicle_id');



        /*
        |--------------------------------------------------------------------------
        | Ranking vehículos más consultados
        |--------------------------------------------------------------------------
        */

        $topVehiculos = PublicVehicleView::selectRaw(
                'vehicle_id, count(*) as total'
            )
            ->with('vehicle')
            ->groupBy('vehicle_id')
            ->orderByDesc('total')
            ->limit(10)
            ->get();



        return view(
            'audit.public-views',
            compact(
                'views',
                'totalConsultas',
                'consultasHoy',
                'pdfVisualizados',
                'vehiculosConsultados',
                'topVehiculos'
            )
        );

    }


    /**
     * Exportación CSV auditoría pública QR
     */
    public function exportPublicViews(Request $request)
    {
        $this->authorize('viewAny', PublicVehicleView::class);


        $query = PublicVehicleView::with([
            'vehicle',
            'document'
        ]);


        if ($request->filled('desde')) {

            $query->whereDate(
                'created_at',
                '>=',
                $request->desde
            );

        }


        if ($request->filled('hasta')) {

            $query->whereDate(
                'created_at',
                '<=',
                $request->hasta
            );

        }


        if ($request->filled('patente')) {

            $query->whereHas(
                'vehicle',
                function($q) use ($request){

                    $q->where(
                        'patente',
                        'like',
                        '%'.$request->patente.'%'
                    );

                }
            );

        }


        if ($request->filled('accion')) {

            $query->where(
                'accion',
                $request->accion
            );

        }


        $views = $query
            ->latest()
            ->get();


        $filename = 'auditoria_qr_'.now()->format('Y-m-d_H-i').'.csv';


        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="'.$filename.'"',
        ];


        $callback = function() use ($views){

            $file = fopen('php://output', 'w');


            fputcsv($file, [
                'Fecha',
                'Patente',
                'Vehículo',
                'Acción',
                'Documento',
                'IP'
            ]);


            foreach($views as $view){

                fputcsv($file, [

                    $view->created_at->format('d-m-Y H:i'),

                    $view->vehicle->patente ?? '-',

                    ($view->vehicle->marca ?? '')
                    .' '.
                    ($view->vehicle->modelo ?? ''),

                    $view->accion,

                    $view->document->tipo_documento ?? '-',

                    $view->ip

                ]);

            }


            fclose($file);

        };


        return response()->stream(
            $callback,
            200,
            $headers
        );

    }


    /**
     * Generación PDF auditoría pública QR
     */
    public function pdfPublicViews(Request $request)
    {
        $this->authorize('viewAny', PublicVehicleView::class);


        $query = PublicVehicleView::with([
            'vehicle',
            'document'
        ]);


        if ($request->filled('desde')) {

            $query->whereDate(
                'created_at',
                '>=',
                $request->desde
            );

        }


        if ($request->filled('hasta')) {

            $query->whereDate(
                'created_at',
                '<=',
                $request->hasta
            );

        }


        if ($request->filled('patente')) {

            $query->whereHas(
                'vehicle',
                function($q) use ($request){

                    $q->where(
                        'patente',
                        'like',
                        '%'.$request->patente.'%'
                    );

                }
            );

        }


        if ($request->filled('accion')) {

            $query->where(
                'accion',
                $request->accion
            );

        }


        $views = $query
            ->latest()
            ->get();


        $totalConsultas = $views->count();


        $vehiculosConsultados = $views
            ->pluck('vehicle_id')
            ->unique()
            ->count();


        $pdf = \PDF::loadView(
            'audit.public-pdf',
            compact(
                'views',
                'totalConsultas',
                'vehiculosConsultados'
            )
        );


        return $pdf->download(
            'SGDV_Auditoria_QR_'.now()->format('Y-m-d').'.pdf'
        );

    }


    /**
     * Auditoría documental
     */
    public function documents(Request $request)
    {
        $this->authorize('viewAny', DocumentAuditLog::class);


        $query = DocumentAuditLog::with([
            'document.vehicle',
            'user'
        ]);


        if ($request->filled('desde')) {

            $query->whereDate(
                'created_at',
                '>=',
                $request->desde
            );

        }


        if ($request->filled('hasta')) {

            $query->whereDate(
                'created_at',
                '<=',
                $request->hasta
            );

        }


        if ($request->filled('accion')) {

            $query->where(
                'accion',
                $request->accion
            );

        }


        $logs = $query
            ->latest()
            ->paginate(25)
            ->withQueryString();


        return view(
            'audit.documents',
            compact('logs')
        );

    }


}
