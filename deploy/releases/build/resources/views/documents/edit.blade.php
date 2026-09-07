<x-app-layout>

<div class="container-xl">

<div class="page-header d-print-none">

<div class="row align-items-center">

<div class="col">

<h2 class="page-title">
Editar documento
</h2>

<div class="text-secondary">
Actualizar información documental del vehículo
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

<li>{{ $error }}</li>

@endforeach

</ul>

</div>

@endif



<form method="POST"
      action="{{ route('documents.update',$document) }}"
      enctype="multipart/form-data">

@csrf
@method('PUT')



<div class="mb-3">

<label class="form-label">
Tipo documento
</label>

<select name="tipo_documento"
        class="form-select"
        required>

@foreach($documentTypes as $type)

<option value="{{ $type->nombre }}"
@selected($document->tipo_documento == $type->nombre)>
{{ $type->nombre }}
</option>

@endforeach

</select>

</div>



<div class="mb-3">

<label class="form-label">
Nombre documento
</label>

<input type="text"
       name="nombre"
       class="form-control"
       value="{{ old('nombre',$document->nombre) }}"
       required>

</div>



<div class="mb-3">

<label class="form-label">
Archivo actual
</label>

<br>

<a href="{{ route('documents.download',$document) }}"
   class="btn btn-outline-secondary">

Descargar archivo actual

</a>

</div>



<div class="mb-3">

<label class="form-label">
Reemplazar archivo (opcional)
</label>

<input type="file"
       name="archivo"
       class="form-control"
       accept=".pdf,.jpg,.jpeg,.png">

<div class="form-hint">

Si no selecciona archivo, se conserva el actual.

</div>

</div>



<div class="row">

<div class="col-md-6 mb-3">

<label class="form-label">
Fecha emisión
</label>

<input type="date"
       name="fecha_emision"
       class="form-control"
       value="{{ old('fecha_emision', optional($document->fecha_emision)->format('Y-m-d')) }}">

</div>


<div class="col-md-6 mb-3">

<label class="form-label">
Fecha vencimiento
</label>

<input type="date"
       name="fecha_vencimiento"
       class="form-control"
       value="{{ old('fecha_vencimiento', optional($document->fecha_vencimiento)->format('Y-m-d')) }}">

</div>

</div>



<div class="card bg-light mb-3">

<div class="card-body">

<h3 class="card-title">
Estado documental actual
</h3>

<div class="row">

<div class="col-md-4">

<label class="form-label text-secondary">
Estado
</label>

<div>
<span class="badge bg-{{ $document->colorEstado() }}">
{{ $document->estadoActual() }}
</span>
</div>

</div>


<div class="col-md-4">

<label class="form-label text-secondary">
Días restantes
</label>

<div>
@if($document->diasRestantes() !== null)

{{ $document->diasRestantes() }} días

@else

Sin fecha definida

@endif
</div>

</div>


<div class="col-md-4">

<label class="form-label text-secondary">
Archivo actual
</label>

<div>
{{ basename($document->archivo) }}
</div>

</div>

</div>

</div>

</div>


<div class="mb-3">

<label class="form-label">
Observación
</label>

<textarea name="observacion"
          class="form-control"
          rows="3">{{ old('observacion',$document->observacion) }}</textarea>

</div>



<button class="btn btn-primary">
Guardar cambios
</button>


<a href="{{ route('documents.show',$document) }}"
   class="btn btn-secondary">

Cancelar

</a>


</form>


</div>

</div>


</div>

</x-app-layout>
