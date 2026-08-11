<!DOCTYPE html>
<html>

<head>

<meta charset="utf-8">

<style>

body {
font-family: DejaVu Sans, sans-serif;
font-size:12px;
}

h1,h2 {
text-align:center;
}

table {
width:100%;
border-collapse:collapse;
margin-top:15px;
}

td,th {
border:1px solid #ccc;
padding:8px;
}

th {
background:#eee;
}

</style>

</head>


<body>


<h1>
{{ $institucion }}
</h1>

<h2>
Reporte Ejecutivo
</h2>


<p>
Fecha:
{{ now()->format('d-m-Y H:i') }}
</p>



<h2>
Resumen documental
</h2>


<table>

<tr>
<th>Vehículos</th>
<td>{{ $totalVehiculos }}</td>
</tr>

<tr>
<th>Documentos</th>
<td>{{ $totalDocumentos }}</td>
</tr>

<tr>
<th>Vigentes</th>
<td>{{ $vigentes }}</td>
</tr>

<tr>
<th>Por vencer</th>
<td>{{ $porVencer }}</td>
</tr>

<tr>
<th>Vencidos</th>
<td>{{ $vencidos }}</td>
</tr>

<tr>
<th>Cumplimiento</th>
<td>{{ $cumplimiento }}%</td>
</tr>

</table>



<h2>
Auditoría QR
</h2>


<table>

<tr>
<th>Consultas QR</th>
<td>{{ $consultasQR }}</td>
</tr>

<tr>
<th>Consultas hoy</th>
<td>{{ $consultasHoy }}</td>
</tr>

<tr>
<th>PDF visualizados</th>
<td>{{ $pdfPublicos }}</td>
</tr>

</table>




<h2>
Vehículos críticos
</h2>


<table>

<tr>

<th>
Patente
</th>

<th>
Cumplimiento
</th>

</tr>


@foreach($vehiculosCriticos as $vehicle)

<tr>

<td>
{{ $vehicle->patente }}
</td>

<td>
{{ $vehicle->porcentajeDocumentacion() }}%
</td>

</tr>

@endforeach


</table>



</body>

</html>
