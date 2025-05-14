<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/dashboard';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'num_documento';
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        // Verificar si el usuario está activo
        if ($user->id_estado != 1) {
            Auth::logout();
            throw ValidationException::withMessages([
                $this->username() => ['Esta cuenta está inactiva. Por favor contacte al administrador.'],
            ]);
        }

        // Redireccionar según el rol
        if ($user->tieneRol('Administrador') || $user->tieneRol('Instructor') || $user->tieneRol('Estudiante')) {
            return redirect()->route('dashboard');
        } else {
            return redirect()->route('home');
        }
    }
}