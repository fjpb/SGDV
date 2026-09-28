<aside class="navbar navbar-vertical navbar-expand-lg sgdv-sidebar offcanvas-lg offcanvas-start" tabindex="-1" id="sgdv-sidebar" aria-labelledby="sgdv-sidebar-label">
<div class="container-fluid flex-column p-0 p-lg-2">

<!-- Mobile Offcanvas Header -->
<div class="offcanvas-header d-lg-none w-100 px-3 pt-3 pb-2 border-bottom border-secondary border-opacity-25">
    <div class="d-flex align-items-center gap-2" id="sgdv-sidebar-label">
        <i class="ti ti-car text-success fs-1"></i>
        <span class="fw-bold fs-1 text-white">SGDV</span>
    </div>
    <button type="button" class="btn-close btn-close-white text-reset" data-bs-dismiss="offcanvas" data-bs-target="#sgdv-sidebar" aria-label="Close"></button>
</div>

<!-- Desktop Brand Header -->
<div class="navbar-brand mb-3 sgdv-brand py-2 d-none d-lg-flex">
    <div class="d-flex flex-column">
        <div class="d-flex align-items-center gap-2">
            <i class="ti ti-car text-success fs-1"></i>
            <span class="fw-bold fs-1">SGDV</span>
        </div>
        <small class="text-secondary">Sistema Gestión Documental Vehicular</small>
    </div>
</div>

<!-- Navigation Body -->
<div class="offcanvas-body p-0 w-100">
<div class="navbar-nav flex-column w-100 py-2">

    <div class="text-secondary small mb-2 px-3">
        GENERAL
    </div>

    <a class="nav-link px-3 {{ request()->routeIs('dashboard') ? 'active' : '' }}"
       href="{{ route('dashboard') }}">
        <i class="ti ti-dashboard me-2"></i>
        Dashboard
    </a>

    <div class="text-secondary small mt-4 mb-2 px-3">
        OPERACIÓN
    </div>

    <a class="nav-link px-3 {{ request()->is('vehicles*') ? 'active' : '' }}"
       href="{{ route('vehicles.index') }}">
        <i class="ti ti-car me-2"></i>
        Vehículos
    </a>

    <a class="nav-link px-3 {{ request()->routeIs('documents.index') ? 'active' : '' }}"
       href="{{ route('documents.index') }}">
        <i class="ti ti-file-text me-2"></i>
        Documentos
    </a>

    <a class="nav-link px-3 {{ request()->routeIs('documents.trash') ? 'active' : '' }}"
       href="{{ route('documents.trash') }}">
        <i class="ti ti-archive me-2"></i>
        Archivados
    </a>

    <a class="nav-link px-3 {{ request()->routeIs('calendar.*') ? 'active' : '' }}"
       href="{{ route('calendar.index') }}">
        <i class="ti ti-calendar me-2"></i>
        Calendario
    </a>

    <div class="text-secondary small mt-4 mb-2 px-3">
        ANÁLISIS
    </div>

    <a class="nav-link px-3 {{ request()->routeIs('reports.*') ? 'active' : '' }}"
       href="{{ route('reports.index') }}">
        <i class="ti ti-chart-bar me-2"></i>
        Reportes
    </a>

    <a class="nav-link px-3 {{ request()->routeIs('audit.index') ? 'active' : '' }}"
       href="{{ route('audit.index') }}">
        <i class="ti ti-shield-check me-2"></i>
        Auditoría
    </a>

    <a class="nav-link px-3 {{ request()->routeIs('audit.public-views') ? 'active' : '' }}"
       href="{{ route('audit.public-views') }}">
        <i class="ti ti-qrcode me-2"></i>
        Consultas QR
    </a>

    <div class="text-secondary small mt-4 mb-2 px-3">
        SISTEMA
    </div>

    <a class="nav-link px-3 {{ request()->routeIs('settings.*') ? 'active' : '' }}"
       href="{{ route('settings.index') }}">
        <i class="ti ti-settings me-2"></i>
        Configuración
    </a>

    <a class="nav-link px-3 {{ request()->routeIs('users.*') ? 'active' : '' }}"
       href="{{ route('users.index') }}">
        <i class="ti ti-users me-2"></i>
        Usuarios
    </a>

    <a class="nav-link px-3 {{ request()->routeIs('profile.*') ? 'active' : '' }}"
       href="{{ route('profile.edit') }}">
        <i class="ti ti-user me-2"></i>
        Mi Perfil
    </a>

</div>
</div>

</div>
</aside>
