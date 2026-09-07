<x-app-layout>

<div class="container-xl">


    <div class="mb-3">

        <a href="{{ route('audit.index') }}"
           class="btn btn-secondary">

            ← Volver auditoría

        </a>

    </div>



    <div class="card mb-3">

        <div class="card-body">


            <form method="GET"
                  action="{{ route('audit.documents') }}">


                <div class="row g-2">


                    <div class="col-md-3">

                        <label class="form-label">
                            Desde
                        </label>


                        <input type="date"
                               name="desde"
                               value="{{ request('desde') }}"
                               class="form-control">

                    </div>



                    <div class="col-md-3">

                        <label class="form-label">
                            Hasta
                        </label>


                        <input type="date"
                               name="hasta"
                               value="{{ request('hasta') }}"
                               class="form-control">

                    </div>



                    <div class="col-md-3">

                        <label class="form-label">
                            Acción
                        </label>


                        <select name="accion"
                                class="form-select">


                            <option value="">
                                Todas
                            </option>


                            <option value="creacion"
                                @selected(request('accion')=='creacion')>

                                Creación

                            </option>


                            <option value="actualizacion"
                                @selected(request('accion')=='actualizacion')>

                                Actualización

                            </option>


                            <option value="eliminacion"
                                @selected(request('accion')=='eliminacion')>

                                Eliminación

                            </option>


                        </select>

                    </div>



                    <div class="col-md-3 d-flex align-items-end">


                        <button class="btn btn-primary w-100">

                            Buscar

                        </button>


                    </div>


                </div>


            </form>


        </div>

    </div>





    <div class="card">


        <div class="card-header">

            <h3 class="card-title">

                Auditoría de documentos

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
                            Vehículo
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


                @forelse($logs as $log)


                    <tr>


                        <td>

                            {{ $log->created_at->format('d-m-Y H:i') }}

                        </td>



                        <td>

                            {{ $log->user->name ?? '-' }}

                        </td>



                        <td>

                            {{ $log->document->tipo_documento ?? '-' }}

                            <br>

                            <small class="text-secondary">

                                {{ $log->document->nombre ?? '' }}

                            </small>

                        </td>



                        <td>

                            {{ $log->document->vehicle->patente ?? '-' }}

                        </td>



                        <td>


                            @if($log->accion == 'eliminacion')

                                <span class="badge bg-red">

                                    Eliminación

                                </span>


                            @elseif($log->accion == 'actualizacion')

                                <span class="badge bg-blue">

                                    Actualización

                                </span>


                            @elseif($log->accion == 'creacion')

                                <span class="badge bg-green">

                                    Creación

                                </span>


                            @else

                                <span class="badge bg-secondary">

                                    {{ $log->accion }}

                                </span>

                            @endif


                        </td>



                        <td>

                            {{ $log->ip_address ?? '-' }}

                        </td>


                    </tr>


                @empty


                    <tr>

                        <td colspan="6"
                            class="text-center">

                            No existen registros.

                        </td>

                    </tr>


                @endforelse


                </tbody>


            </table>


        </div>




        <div class="card-footer">

            {{ $logs->links() }}

        </div>


    </div>


</div>


</x-app-layout>
