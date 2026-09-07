<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Http\Requests\VehicleRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;


class VehicleController extends Controller
{


    /**
     * Listado de vehículos del usuario autenticado
     */
    public function index()
    {

        $vehicles = Auth::user()
            ->vehicles()
            ->latest()
            ->get();


        return view('vehicles.index', compact('vehicles'));

    }



    /**
     * Formulario crear vehículo
     */
    public function create()
    {

        return view('vehicles.create');

    }



    /**
     * Guardar vehículo
     */
    public function store(VehicleRequest $request)
    {


        Auth::user()
            ->vehicles()
            ->create($request->validated());


        return redirect()
            ->route('vehicles.index')
            ->with('success', 'Vehículo registrado correctamente.');

    }



    /**
     * Mostrar vehículo
     */
    public function show(Request $request, Vehicle $vehicle)
    {

        $this->authorizeVehicle($vehicle);


        $estado = $request->get('estado', 'todos');


        $documents = $vehicle->documents;


        if($estado !== 'todos') {

            $documents = $documents->filter(function($document) use ($estado) {


                return match($estado) {

                    'vigente' =>
                        $document->estadoActual() == 'Vigente',


                    'por_vencer' =>
                        $document->estadoActual() == 'Por vencer',


                    'vencido' =>
                        $document->estadoActual() == 'Vencido',


                    default => true

                };


            });

        }


        return view(
            'vehicles.show',
            compact(
                'vehicle',
                'documents',
                'estado'
            )
        );

    }



    /**
     * Editar vehículo
     */
    public function edit(Vehicle $vehicle)
    {

        $this->authorizeVehicle($vehicle);


        return view('vehicles.edit', compact('vehicle'));

    }



    /**
     * Actualizar vehículo
     */
    public function update(
        VehicleRequest $request,
        Vehicle $vehicle
    )
    {

        $this->authorizeVehicle($vehicle);


        $vehicle->update(
            $request->validated()
        );


        return redirect()
            ->route('vehicles.index')
            ->with('success', 'Vehículo actualizado correctamente.');

    }



    /**
     * Archivar vehículo
     */
    public function destroy(Vehicle $vehicle)
    {

        $this->authorizeVehicle($vehicle);


        $vehicle->delete();


        return redirect()
            ->route('vehicles.index')
            ->with('success', 'Vehículo archivado correctamente.');

    }



    /**
     * Generar código QR público del vehículo
     */
    public function qr(Vehicle $vehicle)
    {

        $this->authorizeVehicle($vehicle);


        $url = route(
            'public.vehicle',
            $vehicle->uuid
        );


        return QrCode::size(300)
            ->generate($url);

    }




    /**
     * Validación propietario
     */
    private function authorizeVehicle(Vehicle $vehicle)
    {

        if ($vehicle->user_id !== Auth::id()) {

            abort(403);

        }

    }


}