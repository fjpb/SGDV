<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Valida estado y roles permitidos.
     */
    public function handle(
        Request $request,
        Closure $next,
        ...$roles
    ): Response {

        $user = $request->user();


        if (!$user) {
            abort(403);
        }


        if (!$user->isActive()) {
            abort(403, 'Usuario deshabilitado.');
        }


        if (!in_array($user->role, $roles, true)) {
            abort(403);
        }


        return $next($request);
    }
}
