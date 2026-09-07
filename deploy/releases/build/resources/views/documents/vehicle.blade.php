<x-app-layout>

<div class="container-xl">


<div class="page-header d-print-none">

<div class="row align-items-center">

<div class="col">


<h2 class="page-title">

Documentos del vehículo

</h2>


<div class="text-secondary">

Documentación asociada

</div>


</div>


</div>

</div>




<div class="card">

<div class="card-body">


@if($documents->count())


<table class="table table-vcenter">


<thead>

<tr>

<th>
Documento
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

{{ $document->tipo_documento }}

</td>



<td>

@if($document->fecha_vencimiento)

{{ 
\Carbon\Carbon::parse(
$document->fecha_vencimiento
)->format('d-m-Y')
}}

@endif


</td>



<td>


<span class="badge bg-{{ $document->colorEstado() }}">

{{ $document->estadoActual() }}

</span>


</td>



<td>


<a href="{{ route('documents.show',$document) }}"
class="btn btn-sm">

Ver

</a>


</td>


</tr>


@endforeach


</tbody>


</table>


@else


<div class="text-secondary">

Este vehículo no tiene documentos registrados.

</div>


@endif


</div>

</div>


</div>


</x-app-layout>