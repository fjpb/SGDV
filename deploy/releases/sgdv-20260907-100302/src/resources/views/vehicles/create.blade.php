<x-app-layout>

<div class="container-xl">


    <div class="page-header d-print-none">

        <div class="row align-items-center">

            <div class="col">

                <h2 class="page-title">
                    Registrar vehículo
                </h2>

                <div class="text-secondary mt-1">
                    Agrega un nuevo vehículo al sistema SGDV
                </div>

            </div>

        </div>

    </div>



    <div class="card">

        <div class="card-body">


            <form method="POST"
                  action="{{ route('vehicles.store') }}">

                @csrf



                <div class="row">


                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Patente
                        </label>


                        <input type="text"
                               name="patente"
                               class="form-control @error('patente') is-invalid @enderror"
                               value="{{ old('patente') }}"
                               placeholder="Ej: ABCD12">


                        @error('patente')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>



                    <div class="col-md-6 mb-3">


                        <label class="form-label">
                            Tipo vehículo
                        </label>


                        <select name="tipo"
                                class="form-select @error('tipo') is-invalid @enderror">


                            <option value="">
                                Seleccione
                            </option>


                            <option value="Automóvil">
                                Automóvil
                            </option>


                            <option value="Motocicleta">
                                Motocicleta
                            </option>


                            <option value="Camioneta">
                                Camioneta
                            </option>


                            <option value="Furgón">
                                Furgón
                            </option>


                            <option value="Camión">
                                Camión
                            </option>


                            <option value="Bus">
                                Bus
                            </option>


                            <option value="Otro">
                                Otro
                            </option>


                        </select>


                        @error('tipo')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                        @enderror


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
                               value="{{ old('marca') }}">


                    </div>



                    <div class="col-md-6 mb-3">


                        <label class="form-label">
                            Modelo
                        </label>


                        <input type="text"
                               name="modelo"
                               class="form-control"
                               value="{{ old('modelo') }}">


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
                               value="{{ old('anio') }}">


                    </div>



                    <div class="col-md-6 mb-3">


                        <label class="form-label">
                            Color
                        </label>


                        <input type="text"
                               name="color"
                               class="form-control"
                               value="{{ old('color') }}">


                    </div>


                </div>




                <div class="mt-3">


                    <button type="submit"
                            class="btn btn-primary">

                        Guardar vehículo

                    </button>


                    <a href="{{ route('vehicles.index') }}"
                       class="btn btn-link">

                        Cancelar

                    </a>


                </div>



            </form>


        </div>

    </div>


</div>


</x-app-layout>