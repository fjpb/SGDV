<!DOCTYPE html>
<html>
<head>

<meta charset="utf-8">

<style>

body {
    font-family: Arial, sans-serif;
    font-size: 12px;
}

h1 {
    text-align:center;
}

table {
    width:100%;
    border-collapse:collapse;
}

th, td {
    border:1px solid #ccc;
    padding:6px;
}

th {
    background:#eee;
}

.resumen {
    margin-bottom:20px;
}

</style>

</head>

<body>

<h1>
Reporte documental SGDV
</h1>


<div class="resumen">

<p>
Total documentos: {{ $totalDocumentos }}
</p>

<p>
Vigentes: {{ $vigentes }}
</p>

<p>
Por vencer: {{ $porVencer }}
</p>

<p>
Vencidos: {{ $vencidos }}
</p>

</div>


<table>

<thead>

<tr>

<th>
Patente
</th>

<th>
Vehículo
</th>

<th>
Documento
</th>

<th>
Vencimiento
</th>

<th>
Estado
</th>

</tr>

</thead>


<tbody>

@foreach($documents as $document)

<tr>

<td>
{{ $document->vehicle->patente ?? '-' }}
</td>

<td>
{{ $document->vehicle->marca ?? '' }}
{{ $document->vehicle->modelo ?? '' }}
</td>

<td>
{{ $document->tipo_documento }}
</td>

<td>
{{ optional($document->fecha_vencimiento)->format('d-m-Y') ?? '-' }}
</td>

<td>
{{ $document->estadoActual() }}
</td>

</tr>

@endforeach

</tbody>

</table>


</body>
</html>
