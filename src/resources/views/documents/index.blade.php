<x-app-layout>

<div class="container-xl">


    <div class="page-header d-print-none">

        <div class="row align-items-center">

            <div class="col">

                <h2 class="page-title">
                    Documentos
                </h2>

                <div class="text-secondary">
                    Gestión documental de vehículos
                </div>

            </div>


            <div class="col-auto ms-auto">

                <a href="{{ route('documents.create') }}"
                   class="btn btn-primary">

                    Subir documento

                </a>

            </div>


        </div>

    </div>

    <div class="card">

        <div class="card-body">


        @if($documents->count())


            <div class="table-responsive">


                <table class="table table-vcenter">


                    <thead>

                    <tr>

                        <th>
                            Documento
                        </th>

                        <th>
                            Vehículo
                        </th>

                        <th>
                            Tipo
                        </th>

                        <th>
                            Vencimiento
                        </th>

                        <th>
                            Estado
                        </th>

                        <th>
                            Acción
                        </th>

                    </tr>

                    </thead>



                    <tbody>


                    @foreach($documents as $document)


                    <tr>


                        <td>

                            {{ $document->nombre }}

                        </td>


                        <td>

                            {{ $document->vehicle->patente }}

                        </td>


                        <td>

                            {{ $document->tipo_documento }}

                        </td>



                        <td>


                            @if($document->fecha_vencimiento)

                                {{ 
                                    \Carbon\Carbon::parse(
                                        $document->fecha_vencimiento
                                    )->format('d-m-Y')
                                }}


                                <div class="text-secondary small">

                                    {{ $document->diasRestantes() }}
                                    días restantes

                                </div>


                            @else

                                Sin fecha

                            @endif


                        </td>




                        <td>


                            @if($document->estadoActual() == 'Vigente')


                                <span class="badge bg-success">
                                    Vigente
                                </span>



                            @elseif($document->estadoActual() == 'Por vencer')


                                <span class="badge bg-warning">
                                    Por vencer
                                </span>



                            @elseif($document->estadoActual() == 'Vencido')


                                <span class="badge bg-danger">
                                    Vencido
                                </span>



                            @else


                                <span class="badge bg-secondary">
                                    Sin fecha
                                </span>


                            @endif



                        </td>



                        <td>


                            <a href="{{ route('documents.show',$document) }}"
                               class="btn btn-sm">

                                Descargar

                            </a>


                        </td>



                    </tr>


                    @endforeach


                    </tbody>


                </table>


            </div>


        @else


            <div class="empty">


                <div class="empty-icon">
                    📄
                </div>


                <p class="empty-title">

                    No existen documentos registrados

                </p>


                <p class="empty-subtitle text-secondary">

                    Carga documentos asociados a tus vehículos.

                </p>


            </div>


        @endif



        </div>


    </div>


</div>


</x-app-layout>