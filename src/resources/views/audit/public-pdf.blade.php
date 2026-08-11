<!DOCTYPE html>
<html>
<head>

<meta charset="utf-8">

<style>

body {
    font-family: DejaVu Sans, sans-serif;
    font-size: 11px;
}

h1 {
    text-align:center;
}

table {
    width:100%;
    border-collapse: collapse;
}

th, td {
    border:1px solid #999;
    padding:5px;
}

th {
    background:#eeeeee;
}

.header {
    margin-bottom:20px;
}

</style>

</head>

<body>


<h1>
SGDV
</h1>

<h2>
Informe Auditoría QR Pública
</h2>


<div class="header">

Fecha generación:
{{ now()->format('d-m-Y H:i') }}

<br>

Consultas:
{{ $totalConsultas }}

<br>

Vehículos consultados:
{{ $vehiculosConsultados }}

</div>


<table>

<thead>

<tr>

<th>
Fecha
</th>

<th>
Patente
</th>

<th>
Acción
</th>

<th>
Documento
</th>

<th>
IP
</th>

</tr>

</thead>


<tbody>

@foreach($views as $view)

<tr>

<td>
{{ $view->created_at->format('d-m-Y H:i') }}
</td>

<td>
{{ $view->vehicle->patente ?? '-' }}
</td>

<td>
{{ $view->accion }}
</td>

<td>
{{ $view->document->tipo_documento ?? '-' }}
</td>

<td>
{{ $view->ip }}
</td>

</tr>

@endforeach

</tbody>

</table>


</body>
</html>
