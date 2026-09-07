<x-app-layout>

<div class="container-xl">

    <div class="page-header d-print-none">

        <div class="row align-items-center">

            <div class="col">

                <h2 class="page-title">
                    Dashboard SGDV
                </h2>

                <div class="text-secondary">
                    Gestión documental vehicular
                </div>

            </div>

        </div>

    </div>



    <div class="row row-deck row-cards">


        <!-- Total documentos -->

        <!-- Total vehículos -->

<div class="col-sm-6 col-lg-3">

    <div class="card">

        <div class="card-body">

            <div class="d-flex align-items-center mb-2">

                <span class="avatar me-2">
                    <i class="ti ti-car"></i>
                </span>

                <div class="subheader">
                    Vehículos
                </div>

            </div>


            <div class="h1 mb-0">

                {{ $totalVehiculos }}

            </div>

        </div>

    </div>

</div>




        
<!-- Total documentos -->

<div class="col-sm-6 col-lg-3">

    <div class="card">

        <div class="card-body">

            <div class="subheader">
                Documentos
            </div>

            <div class="h1 mb-0">
                {{ $totalDocumentos }}
            </div>

        </div>

    </div>

</div>


<!-- Vigentes -->

        <div class="col-sm-6 col-lg-3">

            <div class="card">

                <div class="card-body">


                    <div class="subheader">
                        Vigentes
                    </div>


                    <div class="h1 mb-0 text-success">

                        {{ $vigentes }}

                    </div>


                </div>

            </div>

        </div>





        <!-- Por vencer -->

        <div class="col-sm-6 col-lg-3">

            <div class="card">

                <div class="card-body">


                    <div class="subheader">
                        Por vencer
                    </div>


                    <div class="h1 mb-0 text-warning">

                        {{ $porVencer }}

                    </div>


                </div>

            </div>

        </div>





        <!-- Vencidos -->

        <div class="col-sm-6 col-lg-3">

            <div class="card">

                <div class="card-body">


                    <div class="subheader">
                        Vencidos
                    </div>


                    <div class="h1 mb-0 text-danger">

                        {{ $vencidos }}

                    </div>


                </div>

            </div>

        </div>



    </div>





    <div class="row mt-3">

        <div class="col-lg-12">

            <div class="card">

                <div class="card-body">

                    @php
                        $cumplimiento = $totalDocumentos > 0
                            ? round(($vigentes / $totalDocumentos) * 100)
                            : 0;
                    @endphp


                    <div class="d-flex justify-content-between">

                        <div>

                            <h3 class="card-title">
                                Cumplimiento documental
                            </h3>

                            <div class="text-secondary">
                                Porcentaje de documentos vigentes
                            </div>

                        </div>


                        <div class="h2 mb-0">
                            {{ $cumplimiento }}%
                        </div>


                    </div>


                    <div class="progress mt-3">

                        <div class="progress-bar bg-success"
                             style="width: {{ $cumplimiento }}%">
                        </div>

                    </div>


                </div>

            </div>

        </div>

    </div>



    <div class="row row-deck row-cards mt-3">


        <div class="col-lg-8">


            <div class="card">

                <div class="card-header">

                    <h3 class="card-title">
                        Próximos vencimientos
                    </h3>

                </div>


                <div class="card-body">


                        @if($proximosVencimientos->count())


                        <table class="table table-vcenter">


                        <thead>

                        <tr>

                        <th>
                        Documento
                        </th>

                        <th>
                        Vence
                        </th>

                        <th>
                        Estado
                        </th>

                        </tr>

                        </thead>


                        <tbody>


                        @foreach($proximosVencimientos as $document)


                        <tr>


                        <td>

                       <a href="{{ route('documents.show',$document->id) }}">

                            {{ $document->nombre }}

                        </a>

                        <div class="text-secondary small">

                        {{ $document->vehicle->patente }}

                        </div>

                        </td>



                        <td>

                        {{ 
                        \Carbon\Carbon::parse(
                        $document->fecha_vencimiento
                        )->format('d-m-Y')
                        }}


                        <div class="text-secondary small">

                        {{ $document->diasRestantes() }} días

                        </div>


                        </td>




                        <td>


                        <span class="badge bg-{{ $document->colorEstado() }}">

                        {{ $document->estadoActual() }}

                        </span>


                        </td>


                        </tr>


                        @endforeach


                        </tbody>


                        </table>



                        @else


                        <div class="text-secondary">

                        No existen vencimientos próximos.

                        </div>


                        @endif


                        </div>


                                    </div>


                                </div>




        <div class="col-lg-4">

            <div class="card">

                <div class="card-header">

                    <h3 class="card-title">
                        Estado documental
                    </h3>

                </div>

                <div class="card-body">

                    <canvas id="documentStatusChart" height="250"></canvas>

                </div>

            </div>

        </div>



        <div class="col-lg-4">


            <div class="card">

                <div class="card-header">

                    <h3 class="card-title">
                        Acciones rápidas
                    </h3>

                </div>


                <div class="card-body">


                    <div class="d-grid gap-2">


                        <a href="{{ route('vehicles.index') }}"
                           class="btn btn-outline-primary">

                            Ver vehículos

                        </a>



                        <a href="{{ route('documents.create') }}"
                           class="btn btn-primary">

                            Subir documento

                        </a>


                    </div>


                </div>


            </div>


        </div>



    </div>


</div>



<script>

window.documentStatus = {

    vigentes: {{ $vigentes }},

    porVencer: {{ $porVencer }},

    vencidos: {{ $vencidos }}

};

</script>


</x-app-layout>
