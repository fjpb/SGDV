<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{

    public function index()
    {
        $users = User::orderBy('name')->get();

        return view(
            'users.index',
            compact('users')
        );
    }


    public function create()
    {
        return view('users.create');
    }


    public function store(Request $request)
    {

        $validated = $request->validate([

            'name' => [
                'required',
                'string',
                'max:255'
            ],

            'email' => [
                'required',
                'email',
                'unique:users,email'
            ],

            'password' => [
                'required',
                'confirmed',
                Password::defaults()
            ],

            'role' => [
                'required',
                'in:admin,supervisor,user'
            ],

        ]);


        User::create([

            'name' => $validated['name'],

            'email' => $validated['email'],

            'password' => Hash::make(
                $validated['password']
            ),

            'role' => $validated['role'],

            'active' => true,

        ]);


        return redirect()
            ->route('users.index')
            ->with('success','Usuario creado correctamente.');

    }



    public function edit(User $user)
    {
        return view(
            'users.edit',
            compact('user')
        );
    }



    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255'
            ],
            'email' => [
                'required',
                'email',
                'unique:users,email,' . $user->id
            ],
            'role' => [
                'required',
                'in:admin,supervisor,user'
            ],
            'active' => [
                'required',
                'boolean'
            ],
        ]);

        if (
            $user->role === 'admin' &&
            (
                $validated['role'] !== 'admin' ||
                ! $validated['active']
            )
        ) {
            $adminsActivos = User::where('role', 'admin')
                ->where('active', true)
                ->count();

            if ($adminsActivos <= 1) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'role' => 'No es posible desactivar o cambiar el rol del último administrador activo.'
                    ]);
            }
        }

        $user->update($validated);

        return redirect()
            ->route('users.index')
            ->with('success', 'Usuario actualizado.');
    }



 public function destroy(User $user)
{
    // No permitir desactivar la propia cuenta.
    if (auth()->id() === $user->id) {
        return redirect()
            ->route('users.index')
            ->with('error', 'No puede modificar el estado de su propia cuenta.');
    }

    // No permitir desactivar el último administrador activo.
    if (
        $user->isAdmin() &&
        $user->active &&
        User::where('role', 'admin')
            ->where('active', true)
            ->count() <= 1
    ) {
        return redirect()
            ->route('users.index')
            ->with('error', 'No es posible desactivar el último administrador del sistema.');
    }

    // Alternar estado.
    $user->update([
        'active' => ! $user->active,
    ]);

    return redirect()
        ->route('users.index')
        ->with(
            'success',
            $user->active
                ? 'Usuario activado correctamente.'
                : 'Usuario desactivado correctamente.'
        );
}

}
