<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Documento SGDV</title>

<style>

* {
    box-sizing: border-box;
}

body {
    margin:0;
    font-family:Inter, Arial, sans-serif;
    background:#f1f5f9;
    display: flex;
    flex-direction: column;
    min-height: 100vh;
}

.header {
    background:white;
    padding:16px 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    border-bottom: 1px solid #e2e8f0;
}

.header h2 {
    margin: 0;
    font-size: 18px;
    color: #0f172a;
}

.header small {
    color: #64748b;
    font-size: 12px;
}

.status {
    margin:12px 16px;
    padding:12px 16px;
    border-radius:12px;
    background:#dcfce7;
    color:#166534;
    text-align:center;
    font-size: 14px;
    font-weight: 500;
}

.actions-bar {
    padding: 10px 16px;
    background: white;
    border-bottom: 1px solid #e2e8f0;
    display: flex;
    justify-content: center;
    gap: 12px;
}

.btn-download {
    background: #16a34a;
    color: white;
    padding: 10px 20px;
    border-radius: 10px;
    text-decoration: none;
    font-weight: 600;
    font-size: 14px;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    min-height: 44px;
    touch-action: manipulation;
}

.viewer-container {
    flex: 1;
    width: 100%;
    display: flex;
}

.viewer {
    width:100%;
    height:75vh;
    border:0;
    flex: 1;
}

</style>

<script>if ("serviceWorker" in navigator) { navigator.serviceWorker.register("/sw.js"); }</script>
</head>

<body>

<div class="header">

<div>
    <h2>SGDV</h2>
    <small>Sistema Gestión Documental Vehicular</small>
</div>

</div>

<div class="status" id="status">
    Documento consultado desde servidor
</div>

<div class="actions-bar">
    <a href="{{ route('public.document.pdf',$document->uuid) }}" target="_blank" download class="btn-download">
        📄 Abrir / Descargar PDF directamente
    </a>
</div>

<div class="viewer-container">
    <iframe
    class="viewer"
    src="{{ route('public.document.pdf',$document->uuid) }}">
    </iframe>
</div>

<script>

if (!navigator.onLine) {

    document.getElementById('status').innerHTML =
    '⚠ Documento disponible sin conexión';

    document.getElementById('status').style.background =
    '#fef3c7';

    document.getElementById('status').style.color =
    '#92400e';

}

</script>

</body>

</html>
