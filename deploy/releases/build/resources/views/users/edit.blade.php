<x-app-layout>

@section('content')

<div class="container-xl">

<h2 class="mb-4">
Editar usuario
</h2>


<form method="POST" action="{{ route('users.update',$user) }}">

@csrf
@method('PUT')


<div class="mb-3">

<label class="form-label">
Nombre
</label>

<input 
class="form-control"
name="name"
value="{{ $user->name }}"
required>

</div>


<div class="mb-3">

<label class="form-label">
Email
</label>

<input 
class="form-control"
type="email"
name="email"
value="{{ $user->email }}"
required>

</div>


<div class="mb-3">

<label class="form-label">
Rol
</label>

<select class="form-select" name="role">

<option value="user" @selected($user->role==='user')>
Usuario
</option>

<option value="supervisor" @selected($user->role==='supervisor')>
Supervisor
</option>

<option value="admin" @selected($user->role==='admin')>
Administrador
</option>

</select>

</div>


<div class="form-check mb-3">

<input
class="form-check-input"
type="checkbox"
name="active"
value="1"
@checked($user->active)>

<label class="form-check-label">
Activo
</label>

</div>


<button class="btn btn-primary">
Actualizar
</button>


<a href="{{ route('users.index') }}" class="btn btn-secondary">
Cancelar
</a>


</form>

</div>

</x-app-layout>
