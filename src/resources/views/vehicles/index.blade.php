<x-app-layout>

<div class="container-xl">

    <div class="page-header d-print-none mb-3">

        <div class="row align-items-center g-2">

            <div class="col">

                <h2 class="page-title fw-bold">
                    Mis Vehículos
                </h2>

                <div class="text-secondary small">
                    Gestión de vehículos registrados en SGDV
                </div>

            </div>


            <div class="col-12 col-sm-auto ms-sm-auto d-print-none">

                <a href="{{ route('vehicles.create') }}"
                   class="btn btn-primary w-100 w-sm-auto">

                    <i class="ti ti-plus me-1"></i> Nuevo vehículo

                </a>

            </div>

        </div>

    </div>

    @if($vehicles->count())

        {{-- Vista en Tarjetas para Teléfonos Móviles (< 768px) --}}
        <div class="d-md-none">
            <div class="row g-3">
                @foreach($vehicles as $vehicle)
                    @php
                        $cumplimiento = $vehicle->porcentajeDocumentacion();
                    @endphp
                    <div class="col-12">
                        <div class="card sgdv-card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <a href="{{ route('vehicles.show',$vehicle) }}" class="fw-bold text-decoration-none text-dark fs-3">
                                            {{ $vehicle->patente }}
                                        </a>
                                        <div class="text-secondary small">
                                            {{ $vehicle->marca }} {{ $vehicle->modelo }} ({{ $vehicle->anio }})
                                        </div>
                                    </div>
                                    @if($cumplimiento >= 80)
                                        <span class="badge bg-success text-white">
                                            {{ $cumplimiento }}%
                                        </span>
                                    @elseif($cumplimiento >= 50)
                                        <span class="badge bg-warning text-dark">
                                            {{ $cumplimiento }}%
                                        </span>
                                    @else
                                        <span class="badge bg-danger text-white">
                                            {{ $cumplimiento }}%
                                        </span>
                                    @endif
                                </div>

                                <div class="d-flex flex-wrap gap-2 mt-3 pt-2 border-top">
                                    <a href="{{ route('vehicles.documents',$vehicle) }}" class="btn btn-sm btn-outline-primary flex-fill">
                                        <i class="ti ti-file-text me-1"></i> Documentos
                                    </a>
                                    <a href="{{ route('vehicles.card',$vehicle) }}" class="btn btn-sm btn-outline-success flex-fill">
                                        <i class="ti ti-qrcode me-1"></i> Tarjeta QR
                                    </a>
                                    <a href="{{ route('vehicles.edit',$vehicle) }}" class="btn btn-sm btn-outline-secondary">
                                        <i class="ti ti-edit"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Tabla Clásica para Escritorio (>= 768px) --}}
        <div class="card d-none d-md-block">

            <div class="card-body p-0">

                <div class="table-responsive">

                    <table class="table table-vcenter card-table">

                        <thead>

                            <tr>

                                <th>Patente</th>

                                <th>Tipo</th>

                                <th>Marca</th>

                                <th>Modelo</th>

                                <th>Año</th>

                                <th>Documentación</th>

                                <th class="w-1">Acciones</th>

                            </tr>

                        </thead>


                        <tbody>


                        @foreach($vehicles as $vehicle)

                            <tr>

                                <td>
                                    <strong>
                                        <a href="{{ route('vehicles.show',$vehicle) }}" class="text-decoration-none">
                                            {{ $vehicle->patente }}
                                        </a>
                                    </strong>
                                </td>


                                <td>
                                    {{ $vehicle->tipo }}
                                </td>


                                <td>
                                    {{ $vehicle->marca }}
                                </td>


                                <td>
                                    {{ $vehicle->modelo }}
                                </td>


                                <td>
                                    {{ $vehicle->anio }}
                                </td>


                                <td>

                                    @php
                                        $cumplimiento = $vehicle->porcentajeDocumentacion();
                                    @endphp


                                    @if($cumplimiento >= 80)

                                        <span class="badge bg-success">
                                            {{ $cumplimiento }}%
                                        </span>

                                    @elseif($cumplimiento >= 50)

                                        <span class="badge bg-warning">
                                            {{ $cumplimiento }}%
                                        </span>

                                    @else

                                        <span class="badge bg-danger">
                                            {{ $cumplimiento }}%
                                        </span>

                                    @endif

                                </td>


                                <td>

                                    <div class="btn-list flex-nowrap">

                                        <a href="{{ route('vehicles.edit',$vehicle) }}"
                                           class="btn btn-sm">
                                            Editar
                                        </a>

                                        <a href="{{ route('vehicles.documents',$vehicle) }}"
                                           class="btn btn-sm btn-outline-primary">
                                            Documentos
                                        </a>


                                        <a href="{{ route('vehicles.card',$vehicle) }}"
                                           class="btn btn-sm btn-outline-success">
                                            <i class="fa fa-qrcode me-1"></i> Tarjeta QR
                                        </a>

                                        <form method="POST"
                                              action="{{ route('vehicles.destroy',$vehicle) }}"
                                              class="d-inline">

                                            @csrf

                                            @method('DELETE')


                                            <button class="btn btn-sm btn-outline-danger"
                                                    onclick="return confirm('¿Archivar vehículo?')">
                                                Archivar
                                            </button>

                                        </form>

                                    </div>


                                </td>


                            </tr>

                        @endforeach


                        </tbody>


                    </table>


                </div>

            </div>

        </div>


    @else

        <div class="card">
            <div class="card-body">
                <div class="empty">

                    <div class="empty-icon fs-1">
                        🚗
                    </div>

                    <p class="empty-title fw-bold">
                        No tienes vehículos registrados
                    </p>

                    <p class="empty-subtitle text-secondary">
                        Registra tu primer vehículo para comenzar a gestionar sus documentos.
                    </p>

                    <div class="empty-action">
                        <a href="{{ route('vehicles.create') }}" class="btn btn-primary">
                            <i class="ti ti-plus me-1"></i> Registrar Vehículo
                        </a>
                    </div>

                </div>
            </div>
        </div>

    @endif


</div>

</x-app-layout>