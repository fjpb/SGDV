<x-app-layout>

<div class="container-xl">


    <div class="page-header d-print-none">

        <div class="row align-items-center">

            <div class="col">

                <h2 class="page-title">
                    Editar vehículo
                </h2>

            </div>

        </div>

    </div>



    <div class="card">

        <div class="card-body">


            <form method="POST"
                  action="{{ route('vehicles.update',$vehicle) }}">

                @csrf

                @method('PUT')


                <div class="row">


                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Patente
                        </label>

                        <input type="text"
                               name="patente"
                               class="form-control"
                               value="{{ old('patente',$vehicle->patente) }}">


                    </div>



                    <div class="col-md-6 mb-3">


                        <label class="form-label">
                            Tipo vehículo
                        </label>


                        <select name="tipo"
                                class="form-select">


                            @foreach([
                                'Automóvil',
                                'Motocicleta',
                                'Camioneta',
                                'Furgón',
                                'Camión',
                                'Bus',
                                'Otro'
                            ] as $tipo)


                                <option value="{{ $tipo }}"
                                    @selected($vehicle->tipo == $tipo)>

                                    {{ $tipo }}

                                </option>


                            @endforeach


                        </select>


                    </div>


                </div>



                <div class="row">


                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Marca
                        </label>

                        <input type="text"
                               name="marca"
                               class="form-control"
                               value="{{ old('marca',$vehicle->marca) }}">

                    </div>



                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Modelo
                        </label>

                        <input type="text"
                               name="modelo"
                               class="form-control"
                               value="{{ old('modelo',$vehicle->modelo) }}">

                    </div>


                </div>




                <div class="row">


                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Año
                        </label>


                        <input type="number"
                               name="anio"
                               class="form-control"
                               value="{{ old('anio',$vehicle->anio) }}">

                    </div>



                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Color
                        </label>


                        <input type="text"
                               name="color"
                               class="form-control"
                               value="{{ old('color',$vehicle->color) }}">

                    </div>


                </div>




                <button class="btn btn-primary">

                    Actualizar

                </button>


                <a href="{{ route('vehicles.index') }}"
                   class="btn btn-link">

                    Cancelar

                </a>


            </form>


        </div>


    </div>


</div>


</x-app-layout>