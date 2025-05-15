<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Seguridad;

class LogActions
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Procesar la solicitud
        $response = $next($request);
        
        // Registrar la acción si el usuario está autenticado
        if (Auth::check()) {
            $user = Auth::user();
            $action = $request->method() . ' ' . $request->path();
            
            Seguridad::create([
                'Id_Usuario' => $user->Id_Usuario,
                'Accion' => $action,
                'Fecha' => now(),
            ]);
        }
        
        return $response;
    }
}
