<x-app-layout>

<div class="container-xl">


    <div class="card mb-3">

        <div class="card-body">

            <h2 class="card-title">

                Reportes SGDV

            </h2>


            <p class="text-secondary">

                Generación de informes y documentos ejecutivos del sistema.

            </p>

        </div>

    </div>




    <div class="row row-deck row-cards">


        <div class="col-md-6">


            <div class="card">


                <div class="card-body">


                    <h3 class="card-title">

                        Reporte Ejecutivo SGDV

                    </h3>


                    <p class="text-secondary">

                        Resumen general de vehículos, documentos,
                        cumplimiento documental y consultas públicas.

                    </p>


                    <a href="{{ route('reports.executive.pdf') }}"
                       class="btn btn-primary">

                        Generar reporte ejecutivo PDF

                    </a>


                </div>


            </div>


        </div>





        <div class="col-md-6">


            <div class="card">


                <div class="card-body">


                    <h3 class="card-title">

                        Reporte por vehículo

                    </h3>


                    <p class="text-secondary">

                        Ficha completa del vehículo con documentación asociada.

                    </p>


                    <p class="text-secondary mb-0">

                        Disponible desde la ficha del vehículo.

                    </p>


                </div>


            </div>


        </div>




        <div class="col-md-6">


            <div class="card">


                <div class="card-body">


                    <h3 class="card-title">

                        Reporte documental

                    </h3>


                    <p class="text-secondary">

                        Estado de documentos vigentes,
                        vencidos y próximos a vencer.

                    </p>


                    <a href="{{ route('reports.documents') }}"
                       class="btn btn-primary">

                        Ver reporte documental

                    </a>


                </div>


            </div>


        </div>




        <div class="col-md-6">


            <div class="card">


                <div class="card-body">


                    <h3 class="card-title">

                        Reporte consultas QR

                    </h3>


                    <p class="text-secondary">

                        Estadísticas de consultas públicas realizadas.

                    </p>


                    <a href="{{ route('audit.public-views') }}"
                       class="btn btn-success">

                        Ver auditoría QR

                    </a>


                </div>


            </div>


        </div>


    </div>


</div>


</x-app-layout>
