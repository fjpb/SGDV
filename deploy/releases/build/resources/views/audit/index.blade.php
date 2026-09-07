<x-app-layout>

<div class="container-xl">

    <div class="card mb-3">

        <div class="card-body">

            <h3 class="card-title">
                Accesos rápidos
            </h3>


            <div class="btn-list">

                <a href="{{ route('audit.public-views') }}"
                   class="btn btn-primary">

                    Auditoría QR pública

                </a>


                <a href="{{ route('audit.documents') }}"
                   class="btn btn-outline-secondary">

                    Auditoría documentos

                </a>

            </div>

        </div>

    </div>





    <div class="row row-deck row-cards mb-3">


        <div class="col-md-3">

            <div class="card">

                <div class="card-body">

                    <div class="text-secondary">
                        Eventos registrados
                    </div>

                    <div class="h1 mb-0">
                        {{ $totalEventos }}
                    </div>

                </div>

            </div>

        </div>



        <div class="col-md-3">

            <div class="card">

                <div class="card-body">

                    <div class="text-secondary">
                        Documentos auditados
                    </div>

                    <div class="h1 mb-0">
                        {{ $documentosAuditados }}
                    </div>

                </div>

            </div>

        </div>



        <div class="col-md-3">

            <div class="card">

                <div class="card-body">

                    <div class="text-secondary">
                        Usuarios con actividad
                    </div>

                    <div class="h1 mb-0">
                        {{ $usuariosAuditados }}
                    </div>

                </div>

            </div>

        </div>



        <div class="col-md-3">

            <div class="card">

                <div class="card-body">

                    <div class="text-secondary">
                        Última acción
                    </div>


                    @if($ultimoEvento)

                        <div class="h4 mb-1">

                            @if($ultimoEvento->accion == 'eliminacion')

                                <span class="text-danger">
                                    Eliminación
                                </span>

                            @elseif($ultimoEvento->accion == 'actualizacion')

                                <span class="text-primary">
                                    Actualización
                                </span>

                            @else

                                <span class="text-success">
                                    {{ ucfirst($ultimoEvento->accion) }}
                                </span>

                            @endif

                        </div>


                        <div class="small text-secondary">

                            {{ $ultimoEvento->document->tipo_documento ?? 'Documento' }}

                            <br>

                            {{ $ultimoEvento->document->nombre ?? '-' }}

                            <br>

                            Usuario:
                            {{ $ultimoEvento->user->name ?? '-' }}

                            <br>

                            {{ $ultimoEvento->created_at->format('d-m-Y H:i') }}

                        </div>


                    @else

                        <div class="h4 mb-0">
                            Sin registros
                        </div>

                    @endif

                </div>

            </div>

        </div>


    </div>




    <div class="card">


        <div class="card-header">

            <h3 class="card-title">

                Últimos eventos de auditoría

            </h3>


        </div>



        <div class="table-responsive">


            <table class="table table-vcenter">


                <thead>

                    <tr>

                        <th>
                            Fecha
                        </th>

                        <th>
                            Usuario
                        </th>

                        <th>
                            Documento
                        </th>

                        <th>
                            Acción
                        </th>

                        <th>
                            IP
                        </th>


                    </tr>


                </thead>



                <tbody>


                @forelse($ultimosEventos as $evento)


                    <tr>


                        <td>

                            {{ $evento->created_at->format('d-m-Y H:i') }}

                        </td>



                        <td>

                            {{ $evento->user->name ?? '-' }}

                        </td>



                        <td>

                            {{ $evento->document->tipo_documento ?? '-' }}

                            <br>

                            <small class="text-secondary">

                                {{ $evento->document->nombre ?? '' }}

                            </small>

                        </td>



                        <td>

                            @if($evento->accion == 'eliminacion')

                                <span class="badge bg-red">

                                    Eliminación

                                </span>


                            @elseif($evento->accion == 'actualizacion')

                                <span class="badge bg-blue">

                                    Actualización

                                </span>


                            @elseif($evento->accion == 'creacion')

                                <span class="badge bg-green">

                                    Creación

                                </span>


                            @else

                                <span class="badge bg-secondary">

                                    {{ $evento->accion }}

                                </span>

                            @endif

                        </td>



                        <td>

                            {{ $evento->ip_address ?? '-' }}

                        </td>


                    </tr>


                @empty


                    <tr>

                        <td colspan="5" class="text-center">

                            No existen eventos registrados.

                        </td>

                    </tr>


                @endforelse


                </tbody>


            </table>


        </div>


    </div>



    <div class="row row-deck row-cards mt-3">


        <div class="col-md-6">

            <div class="card">

                <div class="card-body">

                    <h3 class="card-title">
                        Auditoría documental
                    </h3>


                    <p class="text-secondary">
                        Historial de creación, modificación y eliminación de documentos.
                    </p>


                    <a href="{{ route('audit.documents') }}"
                       class="btn btn-primary">

                        Ver auditoría documental

                    </a>

                </div>

            </div>

        </div>



        <div class="col-md-6">

            <div class="card">

                <div class="card-body">

                    <h3 class="card-title">
                        Auditoría QR pública
                    </h3>


                    <p class="text-secondary">
                        Consultas externas realizadas mediante códigos QR.
                    </p>


                    <a href="{{ route('audit.public-views') }}"
                       class="btn btn-success">

                        Ver consultas QR

                    </a>

                </div>

            </div>

        </div>


    </div>


</div>


</x-app-layout>
