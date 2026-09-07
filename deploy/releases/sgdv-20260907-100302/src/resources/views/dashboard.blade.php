<x-app-layout>

<div class="container-xl">



<div class="page-header mb-4">

<div>

<h2 class="page-title fw-bold">
Dashboard SGDV
</h2>

<div class="text-secondary">
Control documental vehicular
</div>

</div>

</div>


{{-- KPIs Ejecutivos --}}

<div class="row g-4 mb-4">


<x-sgdv.card-kpi

title="Vehículos"

value="{{ $totalVehiculos }}"

subtitle="Registrados"

icon="ti ti-car"

color="primary"

/>



<x-sgdv.card-kpi

title="Documentos vigentes"

value="{{ $vigentes }}"

subtitle="{{ $porcentajeVigentes }}% cumplimiento"

icon="ti ti-circle-check"

color="success"

/>



<x-sgdv.card-kpi

title="Próximos a vencer"

value="{{ $porVencer }}"

subtitle="Requieren atención"

icon="ti ti-clock"

color="warning"

/>



<x-sgdv.card-kpi

title="Documentos vencidos"

value="{{ $vencidos }}"

subtitle="Acción requerida"

icon="ti ti-alert-triangle"

color="danger"

/>



</div>




{{-- Cumplimiento documental --}}

<div class="card sgdv-card mb-4">

<div class="card-body">


<div class="d-flex justify-content-between align-items-center mb-3">


<div>

<h3 class="card-title mb-1">

Cumplimiento documental

</h3>


<div class="text-secondary">

Estado general de documentación vehicular

</div>


</div>


<div class="h2 text-success mb-0">

{{ $porcentajeVigentes }}%

</div>


</div>



<div class="progress progress-lg">

<div class="progress-bar bg-success"

style="width: {{ $porcentajeVigentes }}%">

</div>

</div>



</div>

</div>



{{-- Alertas --}}


<div class="row g-4">

<div class="col-lg-6">


<div class="card">


<div class="card-header">

<h3 class="card-title">

Alertas documentales

</h3>

</div>


<div class="list-group list-group-flush">


@forelse($proximosVencimientos as $document)


<div class="list-group-item">


<div class="d-flex justify-content-between">


<div>

<div class="fw-bold">

{{ $document->tipo_documento }}

</div>


<div class="text-secondary">

{{ $document->vehicle?->patente ?? '-' }}

</div>


</div>



<span class="badge bg-warning">

{{ $document->diasRestantes() }} días

</span>


</div>


</div>


@empty

<div class="p-3 text-secondary">

Sin alertas pendientes.

</div>

@endforelse


</div>


</div>


</div>




{{-- Vehículos recientes --}}

<div class="col-lg-6">


<div class="card">


<div class="card-header">

<h3 class="card-title">

Vehículos recientes

</h3>

</div>



<div class="list-group list-group-flush">


@foreach($vehiculosRecientes as $vehicle)


<div class="list-group-item">


<div class="d-flex justify-content-between">


<div>

<div class="fw-bold">

{{ $vehicle->marca }}
{{ $vehicle->modelo }}

</div>


<div class="text-secondary">

{{ $vehicle->patente }}

</div>


</div>


<span class="badge bg-success">

Activo

</span>


</div>


</div>


@endforeach


</div>


</div>


</div>


</div>


</div>

</div>


@if($canViewAdministrativeDashboard)

<div class="page-header mb-4">

<h2 class="page-title fw-bold">
Dashboard Ejecutivo
</h2>

<div class="text-secondary">
Indicadores avanzados y consultas públicas QR
</div>

</div>


<div class="row g-4 mb-4">


<x-sgdv.card-kpi

title="Consultas QR"

value="{{ $consultasQR }}"

subtitle="Total histórico"

icon="ti ti-qrcode"

color="primary"

/>


<x-sgdv.card-kpi

title="Consultas hoy"

value="{{ $consultasHoy }}"

subtitle="Actividad diaria"

icon="ti ti-eye"

color="success"

/>


<x-sgdv.card-kpi

title="PDF públicos vistos"

value="{{ $pdfPublicos }}"

subtitle="Documentos consultados"

icon="ti ti-file-text"

color="warning"

/>


<x-sgdv.card-kpi

title="Estado sistema"

value="OK"

subtitle="Servicio operativo"

icon="ti ti-shield-check"

color="success"

/>


</div>


<div class="row g-4 mb-4">

<div class="col-12 col-xl-6">

<div class="card sgdv-card h-100">

<div class="card-header">

<h3 class="card-title">
Vehículos más consultados QR
</h3>

</div>


<div class="table-responsive">

<table class="table card-table">

<thead>

<tr>

<th>Patente</th>

<th>Consultas</th>

</tr>

</thead>


<tbody>

@forelse($topVehiculosQR as $item)

<tr>

<td>
{{ $item->vehicle?->patente ?? '-' }}
</td>

<td>
{{ $item->total }}
</td>

</tr>

@empty

<tr>
<td colspan="2">
Sin datos
</td>
</tr>

@endforelse


</tbody>

</table>

</div>


</div>

</div>




<div class="col-12 col-xl-6">

<div class="card sgdv-card h-100">

<div class="card-header">

<h3 class="card-title">
Documentos más consultados
</h3>

</div>


<div class="table-responsive">

<table class="table card-table">

<thead>

<tr>

<th>Documento</th>

<th>Consultas</th>

</tr>

</thead>


<tbody>

@forelse($topDocumentosQR as $item)

<tr>

<td>
{{ $item->document?->tipo_documento ?? '-' }}
</td>

<td>
{{ $item->total }}
</td>

</tr>

@empty

<tr>
<td colspan="2">
Sin datos
</td>
</tr>

@endforelse


</tbody>

</table>

</div>


</div>

</div>


</div>

@endif



{{-- Analítica avanzada SGDV --}}

@if($canViewAdministrativeDashboard)

<div class="row g-4 mb-4">


<div class="col-lg-6">

<div class="card sgdv-card">

<div class="card-header">

<h3 class="card-title">
Estado documental
</h3>

</div>

<div class="card-body">

<canvas id="documentStatusChart"></canvas>

</div>

</div>

</div>



<div class="col-lg-6">

<div class="card sgdv-card">

<div class="card-header">

<h3 class="card-title">
Últimas acciones de auditoría
</h3>

</div>


<div class="list-group list-group-flush">

@forelse($ultimosEventos as $evento)

<div class="list-group-item">

<div class="fw-bold">
{{ ucfirst($evento->accion) }}
</div>

<div class="text-secondary">

{{ $evento->document?->tipo_documento ?? 'Documento eliminado' }}

-

{{ $evento->user->name ?? 'Sistema' }}

</div>

</div>

@empty

<div class="p-3 text-secondary">
Sin eventos registrados.
</div>

@endforelse


</div>

</div>

</div>


</div>



<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

new Chart(
document.getElementById('documentStatusChart'),
{
type:'doughnut',

data:{

labels:[
'Vigentes',
'Por vencer',
'Vencidos'
],

datasets:[{

data:[

{{ $estadoDocumental['vigentes'] }},

{{ $estadoDocumental['porVencer'] }},

{{ $estadoDocumental['vencidos'] }}

]

}]

}

}

);

</script>



{{-- Tendencia consultas QR --}}

<div class="card sgdv-card mb-4">

<div class="card-header">

<h3 class="card-title">
Consultas QR últimos 30 días
</h3>

</div>


<div class="card-body">

<canvas id="qrActivityChart"></canvas>

</div>


</div>



<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<script>

new Chart(
document.getElementById('qrActivityChart'),
{

type:'line',

data:{

labels:[

@foreach($graficoQR as $item)
"{{ $item->fecha }}",
@endforeach

],

datasets:[{

label:'Consultas QR',

data:[

@foreach($graficoQR as $item)
{{ $item->total }},
@endforeach

],

tension:0.3

}]

}

}

);

</script>


@endif


</x-app-layout>
