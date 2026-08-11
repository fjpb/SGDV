<header class="navbar navbar-expand-md d-print-none sgdv-navbar">

<div class="container-xl">


<div class="navbar-nav flex-row">


<div class="d-flex flex-column">

<span class="fw-bold">
SGDV
</span>

<small class="text-secondary">
Sistema Gestión Documental Vehicular
</small>

</div>


</div>



<div class="navbar-nav flex-row order-md-last">


<div class="nav-item dropdown">


<a href="#"
class="nav-link d-flex align-items-center text-reset"
data-bs-toggle="dropdown">


<span class="avatar avatar-sm bg-success text-white">

{{ strtoupper(substr(auth()->user()->name ?? 'U',0,2)) }}

</span>


<div class="d-none d-xl-block ps-2">


<div class="fw-semibold">

{{ auth()->user()->name ?? 'Usuario' }}

</div>


<div class="small text-secondary">

{{ auth()->user()->role ?? 'Usuario' }}

</div>


</div>


</a>


<div class="dropdown-menu dropdown-menu-end">


<a href="{{ route('profile.edit') }}"
class="dropdown-item">

<i class="ti ti-user me-2"></i>

Mi perfil

</a>



<div class="dropdown-divider"></div>



<form method="POST"
action="{{ route('logout') }}">

@csrf

<button type="submit"
class="dropdown-item">

<i class="ti ti-logout me-2"></i>

Cerrar sesión

</button>

</form>


</div>


</div>


</div>


</div>


</header>
