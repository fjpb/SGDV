<x-app-layout>

@if ($errors->any())
<div class="alert alert-danger">
<ul>
@foreach ($errors->all() as $error)
<li>{{ $error }}</li>
@endforeach
</ul>
</div>
@endif

@if(session("success"))
<div class="alert alert-success">
{{ session("success") }}
</div>
@endif


<div class="container-xl">

<h2 class="mb-4">
Crear usuario
</h2>

<form method="POST" action="{{ route('users.store') }}">

@csrf

<div class="mb-3">
<label class="form-label">Nombre</label>
<input class="form-control" name="name" required>
</div>

<div class="mb-3">
<label class="form-label">Email</label>
<input class="form-control" type="email" name="email" required>
</div>

<div class="mb-3">
<label class="form-label">Contraseña</label>
<input class="form-control" type="password" name="password" required>
</div>


<div class="mb-3">

<label class="form-label">
Confirmar contraseña
</label>

<input 
class="form-control"
type="password"
name="password_confirmation"
required>

</div>

<div class="mb-3">
<label class="form-label">Rol</label>

<select class="form-select" name="role">

<option value="user">Usuario</option>
<option value="supervisor">Supervisor</option>
<option value="admin">Administrador</option>

</select>

</div>

<div class="form-check mb-3">

<input 
class="form-check-input"
type="checkbox"
name="active"
value="1"
checked>

<label class="form-check-label">
Activo
</label>

</div>

<button class="btn btn-primary">
Guardar
</button>

<a href="{{ route('users.index') }}" class="btn btn-secondary">
Cancelar
</a>

</form>

</div>

</x-app-layout>
