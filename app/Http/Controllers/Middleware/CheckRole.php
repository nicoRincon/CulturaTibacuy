<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

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
        $roleArray = explode('|', $roles);
        
        $userHasRequiredRole = false;
        foreach ($roleArray as $role) {
            if ($user->tieneRol(trim($role))) {
                $userHasRequiredRole = true;
                break;
            }
        }
        
        if (!$userHasRequiredRole) {
            return redirect()->route('dashboard')->with('error', 'No tienes permiso para acceder a esta página.');
        }

        return $next($request);
    }
}