<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Rol;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $roles  Lista de roles separados por pipe (|)
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $roles)
    {
        if (!Auth::check()) {
            return redirect('login');
        }

        $user = Auth::user();
        $rolesArray = explode('|', $roles);

        if (!in_array($user->rol->rol, $rolesArray)) {
            return redirect('dashboard')->with('error', 'No tienes permisos para acceder a esta página');
        }

        return $next($request);
    }
}