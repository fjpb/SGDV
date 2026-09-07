<x-app-layout>

<div class="container-xl">

    
    <div class="card mb-3">

        <div class="card-body">

            <form method="GET" action="{{ route('audit.public-views') }}">

                <div class="row g-2">


                    <div class="col-md-2">

                        <label class="form-label">
                            Desde
                        </label>

                        <input 
                            type="date"
                            name="desde"
                            value="{{ request('desde') }}"
                            class="form-control"
                        >

                    </div>



                    <div class="col-md-2">

                        <label class="form-label">
                            Hasta
                        </label>

                        <input 
                            type="date"
                            name="hasta"
                            value="{{ request('hasta') }}"
                            class="form-control"
                        >

                    </div>



                    <div class="col-md-3">

                        <label class="form-label">
                            Patente
                        </label>

                        <input 
                            type="text"
                            name="patente"
                            value="{{ request('patente') }}"
                            class="form-control"
                            placeholder="Ej: ABCD12"
                        >

                    </div>



                    <div class="col-md-3">

                        <label class="form-label">
                            Acción
                        </label>

                        <select 
                            name="accion"
                            class="form-select"
                        >

                            <option value="">
                                Todas
                            </option>

                            <option 
                                value="consulta_qr"
                                @selected(request('accion')=='consulta_qr')
                            >
                                Consulta QR
                            </option>


                            <option 
                                value="visualizacion_pdf"
                                @selected(request('accion')=='visualizacion_pdf')
                            >
                                PDF abierto
                            </option>


                        </select>

                    </div>



                    <div class="col-md-2 d-flex align-items-end">

                        <button class="btn btn-success w-100">

                            Buscar

                        </button>

                    </div>


                    <div class="col-md-2 d-flex align-items-end">

                        <a 
                            href="{{ route('audit.public-views') }}"
                            class="btn btn-secondary w-100"
                        >

                            Limpiar

                        </a>

                    </div>


                    <div class="col-md-2 d-flex align-items-end">

                        <a 
                            href="{{ route('audit.public-views.export', request()->query()) }}"
                            class="btn btn-primary w-100"
                        >

                            Exportar CSV

                        </a>

                    </div>


                    <div class="col-md-2 d-flex align-items-end">

                        <a 
                            href="{{ route('audit.public-views.pdf', request()->query()) }}"
                            class="btn btn-danger w-100"
                        >

                            Exportar PDF

                        </a>

                    </div>


                </div>


            </form>


        </div>

    </div>



<div class="row row-deck row-cards mb-3">

        <div class="col-md-3">
            <div class="card">
                <div class="card-body">

                    <div class="text-secondary">
                        Consultas totales
                    </div>

                    <div class="h1 mb-0">
                        {{ $totalConsultas }}
                    </div>

                </div>
            </div>
        </div>


        <div class="col-md-3">
            <div class="card">
                <div class="card-body">

                    <div class="text-secondary">
                        Consultas hoy
                    </div>

                    <div class="h1 mb-0 text-success">
                        {{ $consultasHoy }}
                    </div>

                </div>
            </div>
        </div>


        <div class="col-md-3">
            <div class="card">
                <div class="card-body">

                    <div class="text-secondary">
                        PDFs visualizados
                    </div>

                    <div class="h1 mb-0 text-success">
                        {{ $pdfVisualizados }}
                    </div>

                </div>
            </div>
        </div>


        <div class="col-md-3">
            <div class="card">
                <div class="card-body">

                    <div class="text-secondary">
                        Vehículos consultados
                    </div>

                    <div class="h1 mb-0">
                        {{ $vehiculosConsultados }}
                    </div>

                </div>
            </div>
        </div>

    </div>



    <div class="card mb-3">

        <div class="card-header">

            <h3 class="card-title">
                Vehículos más consultados
            </h3>

        </div>


        <div class="table-responsive">

            <table class="table table-vcenter">

                <thead>

                    <tr>
                        <th>#</th>
                        <th>Patente</th>
                        <th>Vehículo</th>
                        <th class="text-end">
                            Consultas
                        </th>
                    </tr>

                </thead>


                <tbody>

                @forelse($topVehiculos as $index => $item)

                    <tr>

                        <td>
                            {{ $index + 1 }}
                        </td>


                        <td>
                            <strong>
                                {{ $item->vehicle->patente ?? '-' }}
                            </strong>
                        </td>


                        <td>
                            {{ $item->vehicle->marca ?? '' }}
                            {{ $item->vehicle->modelo ?? '' }}
                        </td>


                        <td class="text-end">

                            <span class="badge bg-green">

                                {{ $item->total }}

                            </span>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="4" class="text-center">
                            Sin consultas registradas
                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </div>




    <div class="card">

        <div class="card-header">

            <h3 class="card-title">
                Consultas QR Públicas
            </h3>

        </div>


        <div class="table-responsive">

            <table class="table table-vcenter">

                <thead>

                    <tr>
                        <th>Fecha</th>
                        <th>Patente</th>
                        <th>Acción</th>
                        <th>Documento</th>
                        <th>IP</th>
                        <th>Navegador</th>
                    </tr>

                </thead>


                <tbody>

                @forelse($views as $view)

                    <tr>

                        <td>
                            {{ $view->created_at->format('d-m-Y H:i') }}
                        </td>


                        <td>
                            {{ $view->vehicle->patente ?? '-' }}
                        </td>


                        <td>

                            @if($view->accion == 'consulta_qr')

                                <span class="badge bg-success">
                                    Consulta QR
                                </span>

                            @elseif($view->accion == 'visualizacion_pdf')

                                <span class="badge bg-blue">
                                    PDF abierto
                                </span>

                            @else

                                {{ $view->accion }}

                            @endif

                        </td>


                        <td>
                            {{ $view->document->tipo_documento ?? '-' }}
                        </td>


                        <td>
                            {{ $view->ip }}
                        </td>


                        <td style="max-width:350px">

                            {{ $view->user_agent }}

                        </td>


                    </tr>


                @empty

                    <tr>

                        <td colspan="6" class="text-center">
                            No existen consultas registradas.
                        </td>

                    </tr>


                @endforelse


                </tbody>


            </table>


        </div>


        <div class="card-footer">

            {{ $views->links() }}

        </div>


    </div>


</div>

</x-app-layout>
