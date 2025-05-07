<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
    protected $redirectTo = '/home';

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
            'segundo_nombre' => ['nullable', 'string', 'max:50'],
            'primer_apellido' => ['required', 'string', 'max:50'],
            'segundo_apellido' => ['nullable', 'string', 'max:50'],
            'id_documento' => ['required', 'integer', 'exists:documento_de_identificacion,id_documento'],
            'id_estado' => ['required', 'integer', 'exists:estados,id_estado'],
            'num_documento' => ['required', 'string', 'max:20', 'unique:usuarios'],
            'fecha_nacimiento' => ['required', 'date'],
            'id_lugar_nacimiento' => ['required', 'integer', 'exists:lugar_de_nacimiento,id_lugar_nacimiento'],
            'id_genero' => ['required', 'integer', 'exists:generos,id_genero'],
            'id_rol' => ['required', 'integer', 'exists:roles,id_rol'],
            'id_contacto' => ['nullable', 'integer', 'exists:contactos,id_contacto'],
            'id_especialidad' => ['nullable', 'integer', 'exists:especialidades,id_especialidad'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:usuarios'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }
    
    protected function create(array $data)
    {
        return User::create([
            'primer_nombre' => $data['primer_nombre'],
            'segundo_nombre' => $data['segundo_nombre'] ?? null,
            'primer_apellido' => $data['primer_apellido'],
            'segundo_apellido' => $data['segundo_apellido'] ?? null,
            'id_documento' => $data['id_documento'],
            'id_estado' => $data['id_estado'],
            'num_documento' => $data['num_documento'],
            'fecha_nacimiento' => $data['fecha_nacimiento'],
            'id_lugar_nacimiento' => $data['id_lugar_nacimiento'],
            'id_genero' => $data['id_genero'],
            'id_rol' => $data['id_rol'],
            'id_contacto' => $data['id_contacto'] ?? null,
            'id_especialidad' => $data['id_especialidad'] ?? null,
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
