<!DOCTYPE html>
<html>

<head>

<meta charset="utf-8">

<title>
Reporte SGDV
</title>


<style>

body {

    font-family: DejaVu Sans, sans-serif;
    font-size: 12px;

}


.header {

    text-align:center;
    margin-bottom:20px;

}


h1 {

    font-size:20px;

}


.section {

    margin-top:20px;

}


table {

    width:100%;
    border-collapse:collapse;

}


th {

    background:#eeeeee;

}


td, th {

    border:1px solid #cccccc;
    padding:8px;

}


.badge {

    padding:4px;

}


</style>


</head>


<body>


<div class="header">

<h1>
SGDV
</h1>

<h3>
Sistema de Gestión Documental Vehicular
</h3>

<p>
Reporte generado:
{{ now()->format('d-m-Y H:i') }}
</p>

</div>



<div class="section">

<h2>
Datos del vehículo
</h2>


<table>


<tr>

<th>
Patente
</th>

<td>
{{ $vehicle->patente }}
</td>

</tr>


<tr>

<th>
Marca
</th>

<td>
{{ $vehicle->marca }}
</td>

</tr>


<tr>

<th>
Modelo
</th>

<td>
{{ $vehicle->modelo }}
</td>

</tr>


<tr>

<th>
Año
</th>

<td>
{{ $vehicle->anio }}
</td>

</tr>


<tr>

<th>
Tipo
</th>

<td>
{{ $vehicle->tipo }}
</td>

</tr>


<tr>

<th>
Color
</th>

<td>
{{ $vehicle->color }}
</td>

</tr>


</table>


</div>




<div class="section">


<h2>
Documentación
</h2>


<table>


<thead>

<tr>

<th>
Documento
</th>

<th>
Estado
</th>

<th>
Vencimiento
</th>

</tr>

</thead>


<tbody>


@foreach($vehicle->documents as $document)


<tr>

<td>
{{ $document->tipo_documento }}
</td>


<td>
{{ $document->estadoActual() }}
</td>


<td>

@if($document->fecha_vencimiento)

{{ $document->fecha_vencimiento->format('d-m-Y') }}

@else

Sin fecha

@endif

</td>


</tr>


@endforeach


</tbody>


</table>


</div>




<div class="section">


<h2>
Resumen documental
</h2>


<table>


<tr>

<th>
Total documentos
</th>

<td>
{{ $vehicle->totalDocumentos() }}
</td>

</tr>


<tr>

<th>
Vigentes
</th>

<td>
{{ $vehicle->documentosVigentes() }}
</td>

</tr>


<tr>

<th>
Por vencer
</th>

<td>
{{ $vehicle->documentosPorVencer() }}
</td>

</tr>


<tr>

<th>
Vencidos
</th>

<td>
{{ $vehicle->documentosVencidos() }}
</td>

</tr>


<tr>

<th>
Cumplimiento
</th>

<td>
{{ $vehicle->porcentajeDocumentacion() }}%
</td>

</tr>


</table>


</div>



<div class="section">


<h2>
Identificador público
</h2>


<p>

UUID:

{{ $vehicle->uuid }}

</p>


</div>



</body>

</html>
