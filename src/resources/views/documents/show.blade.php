<x-app-layout>

<div class="container-xl">

    {{-- ============================================================= --}}
    {{-- Encabezado                                                    --}}
    {{-- ============================================================= --}}
    <div class="page-header d-print-none">

        <div class="row align-items-center">

            <div class="col">

                <h2 class="page-title">

                    {{ $document->nombre }}

                </h2>

                <div class="text-secondary">

                    Información del documento

                </div>

            </div>

        </div>

    </div>


    {{-- ============================================================= --}}
    {{-- Información principal                                         --}}
    {{-- ============================================================= --}}
    <div class="card">

        <div class="card-header">

            <h3 class="card-title">

                Datos generales

            </h3>

        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-md-6">

                    <table class="table table-borderless">

                        <tr>

                            <th width="180">

                                Tipo

                            </th>

                            <td>

                                {{ $document->tipo_documento }}

                            </td>

                        </tr>

                        <tr>

                            <th>

                                Vehículo

                            </th>

                            <td>

                                {{ $document->vehicle?->patente ?? '-' }}

                            </td>

                        </tr>

                        <tr>

                            <th>

                                Marca / Modelo

                            </th>

                            <td>

                                {{ $document->vehicle->marca }}
                                {{ $document->vehicle->modelo }}

                            </td>

                        </tr>

                        <tr>

                            <th>

                                Año

                            </th>

                            <td>

                                {{ $document->vehicle->anio }}

                            </td>

                        </tr>

                    </table>

                </div>


                <div class="col-md-6">

                    <table class="table table-borderless">

                        <tr>

                            <th width="180">

                                Fecha emisión

                            </th>

                            <td>

                                {{ $document->fecha_emision
                                    ? \Carbon\Carbon::parse($document->fecha_emision)->format('d-m-Y')
                                    : '-' }}

                            </td>

                        </tr>

                        <tr>

                            <th>

                                Fecha vencimiento

                            </th>

                            <td>

                                {{ $document->fecha_vencimiento
                                    ? \Carbon\Carbon::parse($document->fecha_vencimiento)->format('d-m-Y')
                                    : '-' }}

                            </td>

                        </tr>

                        <tr>

                            <th>

                                Estado

                            </th>

                            <td>

                                <span class="badge bg-{{ $document->colorEstado() }}">

                                    {{ $document->estadoActual() }}

                                </span>

                            </td>

                        </tr>

                        <tr>

                            <th>

                                Días restantes

                            </th>

                            <td>

                                @if($document->diasRestantes() !== null)

                                    {{ $document->diasRestantes() }} días

                                @else

                                    -

                                @endif

                            </td>

                        </tr>

                    </table>

                </div>

            </div>

        </div>

    </div>


    {{-- ============================================================= --}}
    {{-- Observaciones                                                 --}}
    {{-- ============================================================= --}}
    <div class="card mt-3">

        <div class="card-header">

            <h3 class="card-title">

                Observaciones

            </h3>

        </div>

        <div class="card-body">

            {{ $document->observacion ?: 'Sin observaciones.' }}

        </div>

    </div>


    {{-- ============================================================= --}}
    {{-- ============================================================= --}}
    {{-- ============================================================= --}}
    {{-- Historial de versiones                                        --}}
    {{-- ============================================================= --}}
    <div class="card mt-3">

        <div class="card-header">
            <h3 class="card-title">
                Historial de versiones
            </h3>
        </div>


        <div class="card-body">

            @forelse($document->histories->sortByDesc('version') as $history)

                <details class="mb-3 border rounded p-3">

                    <summary class="fw-bold cursor-pointer">

                        Versión {{ $history->version }}

                        @if($history->accion === 'edicion')
                            <span class="badge bg-blue ms-2">
                                Edición
                            </span>
                        @elseif($history->accion === 'restauracion')
                            <span class="badge bg-green ms-2">
                                Restauración
                            </span>
                        @else
                            <span class="badge bg-secondary ms-2">
                                {{ ucfirst($history->accion) }}
                            </span>
                        @endif

                    </summary>


                    <div class="mt-3">

                        <p>
                            <strong>Fecha:</strong>
                            {{ $history->created_at->format('d-m-Y H:i') }}
                        </p>


                        <p>
                            <strong>Usuario:</strong>
                            {{ $history->creator->name ?? '-' }}
                        </p>


                        <p>
                            <strong>Documento:</strong>
                            {{ $history->nombre }}
                        </p>


                        @if($history->archivo)

                            <a href="{{ asset('storage/'.$history->archivo) }}"
                               target="_blank"
                               class="btn btn-sm btn-outline-primary">

                                Ver archivo

                            </a>

                        @endif


                        <form method="POST"
                              class="d-inline"
                              action="{{ route('documents.restore',$history) }}">

                            @csrf

                            <button class="btn btn-sm btn-warning"
                                    onclick="return confirm('¿Restaurar esta versión?')">

                                Restaurar

                            </button>

                        </form>


                    </div>

                </details>


            @empty

                <div class="text-secondary">
                    No existen versiones anteriores.
                </div>

            @endforelse

        </div>

    </div>


    {{-- Auditoría documental                                         --}}
    {{-- ============================================================= --}}

    <div class="card mt-3">

        <div class="card-header">
            <h3 class="card-title">
                Auditoría documental
            </h3>
        </div>


        <div class="table-responsive">

            <table class="table table-vcenter">

                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Usuario</th>
                        <th>Acción</th>
                        <th>IP</th>
                    </tr>
                </thead>


                <tbody>

                @forelse($document->auditLogs->sortByDesc('created_at') as $audit)

                    <tr>

                        <td>
                            {{ $audit->created_at->format('d-m-Y H:i') }}
                        </td>


                        <td>
                            {{ $audit->user->name ?? '-' }}
                        </td>


                        <td>

                            @switch($audit->accion)

                                @case('creacion')
                                    <span class="badge bg-green">
                                        Creación
                                    </span>
                                    @break

                                @case('edicion')
                                    <span class="badge bg-blue">
                                        Edición
                                    </span>
                                    @break

                                @case('eliminacion')
                                    <span class="badge bg-red">
                                        Archivado
                                    </span>
                                    @break

                                @case('restauracion')
                                    <span class="badge bg-yellow">
                                        Restauración
                                    </span>
                                    @break

                                @default
                                    <span class="badge bg-secondary">
                                        {{ $audit->accion }}
                                    </span>

                            @endswitch

                        </td>


                        <td>
                            {{ $audit->ip_address ?? '-' }}
                        </td>

                    </tr>


                @empty

                    <tr>
                        <td colspan="4"
                            class="text-secondary text-center">

                            No existen registros de auditoría.

                        </td>
                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </div>



    {{-- Acciones                                                      --}}
    {{-- ============================================================= --}}
    <div class="mt-3">

        <a
            href="{{ route('documents.download', $document->id) }}"
            class="btn btn-primary">

            Descargar documento

        </a>

        <a
            href="{{ route('documents.edit', $document->id) }}"
            class="btn btn-warning">

            Editar

        </a>

        <form
            method="POST"
            action="{{ route('documents.destroy', $document->id) }}"
            class="d-inline">

            @csrf
            @method('DELETE')

            <button
                type="submit"
                class="btn btn-danger"
                onclick="return confirm('¿Archivar este documento?')">

                Archivar

            </button>

        </form>


        <a
            href="{{ route('documents.index') }}"
            class="btn btn-secondary">

            Volver

        </a>

    </div>

</div>

</x-app-layout>