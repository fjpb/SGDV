<x-app-layout>

<div class="container-xl">


<div class="page-header d-print-none">

<div class="row align-items-center">

<div class="col">

<h2 class="page-title">
Subir documento
</h2>

<div class="text-secondary">
Asociar documento a un vehículo
</div>

</div>

</div>

</div>



<div class="card">

<div class="card-body">

@if($errors->any())

<div class="alert alert-danger">

<ul class="mb-0">

@foreach($errors->all() as $error)

<li>
{{ $error }}
</li>

@endforeach

</ul>

</div>

@endif
<form method="POST"
      action="{{ route('documents.store') }}"
      enctype="multipart/form-data">


@csrf



<div class="row">


<div class="col-md-6 mb-3">


<label class="form-label">
Vehículo
</label>


<select name="vehicle_id"
        class="form-select"
        required>


<option value="">
Seleccione vehículo
</option>


@foreach($vehicles as $vehicle)


<option value="{{ $vehicle->id }}"
@if(isset($selectedVehicle) && $selectedVehicle == $vehicle->id)
selected
@endif
>

{{ $vehicle->patente }}
-
{{ $vehicle->marca }}
{{ $vehicle->modelo }}

</option>


@endforeach


</select>


</div>



<div class="col-md-6 mb-3">


<label class="form-label">
Tipo documento
</label>

<select
    name="tipo_documento"
    class="form-select"
    required>


    <option value="">
        Seleccione un tipo
    </option>


    @foreach($documentTypes as $type)


        <option
            value="{{ $type->nombre }}"
            @selected(old('tipo_documento') == $type->nombre)>


            {{ $type->nombre }}


        </option>


    @endforeach


</select>


</div>


</div>





<div class="mb-3">


<label class="form-label">
Nombre documento
</label>


<input type="text"
       name="nombre"
       class="form-control"
       placeholder="Ej: SOAP 2026"
       required>


</div>





<div class="mb-3">


<label class="form-label">
Archivo
</label>


<input type="file"
       name="archivo"
       class="form-control"
       accept=".pdf,.jpg,.jpeg,.png"
       required>


<div class="form-hint">

Formatos permitidos:
PDF, JPG, JPEG, PNG.

<br>

Tamaño máximo:
10 MB.

</div>





<div class="row">


<div class="col-md-6 mb-3">


<label class="form-label">
Fecha emisión
</label>


<input type="date"
       name="fecha_emision"
       class="form-control">


</div>




<div class="col-md-6 mb-3">


<label class="form-label">
Fecha vencimiento
</label>


<input type="date"
       name="fecha_vencimiento"
       class="form-control">


</div>


</div>





<div class="mb-3">


<label class="form-label">
Observaciones
</label>


<textarea name="observacion"
          class="form-control"
          rows="3"></textarea>


</div>





<button class="btn btn-primary">

Guardar documento

</button>



<a href="{{ route('documents.index') }}"
   class="btn btn-link">

Cancelar

</a>



</form>


</div>


</div>


</div>


</x-app-layout>