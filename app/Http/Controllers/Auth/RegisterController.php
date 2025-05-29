<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Contacto;
use App\Models\LugarNacimiento;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'primer_nombre' => ['required', 'string', 'max:50'],
            'primer_apellido' => ['required', 'string', 'max:50'],
            'email' => ['required', 'string', 'email', 'max:100', 'unique:contactos,email'],
            'num_documento' => ['required', 'string', 'max:20', 'unique:usuarios'],
            'password' => ['required', 'string', 'min:8', 'confirmed','regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]/'],
        ]);
    }

    protected function create(array $data)
    {
        // Primero crear contacto
        $contacto = Contacto::create([
            'email' => $data['email'],
            'telefono' => $data['telefono'] ?? '',
            'direccion' => $data['direccion'] ?? '',
        ]);
        
        // Crear lugar de nacimiento predeterminado (se puede actualizar después)
        $lugarNacimiento = LugarNacimiento::first();
        
        return User::create([
            'primer_nombre' => $data['primer_nombre'],
            'segundo_nombre' => $data['segundo_nombre'] ?? null,
            'primer_apellido' => $data['primer_apellido'],
            'segundo_apellido' => $data['segundo_apellido'] ?? null,
            'id_documento' => 1, // Predeterminado - se puede actualizar luego
            'id_estado' => 1, // Activo por defecto
            'num_documento' => $data['num_documento'],
            'fecha_nacimiento' => $data['fecha_nacimiento'] ?? now()->subYears(18),
            'id_lugar_nacimiento' => $lugarNacimiento->id_lugar_nacimiento,
            'id_genero' => 1, // Predeterminado - se puede actualizar luego
            'id_rol' => 3, // Rol de estudiante por defecto
            'id_contacto' => $contacto->id_contacto,
            'id_especialidad' => 1, // Predeterminado - se puede actualizar luego
            'password' => Hash::make($data['password']),
        ]);
    }
}
