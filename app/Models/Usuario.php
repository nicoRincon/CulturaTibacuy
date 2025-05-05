<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Usuario extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'Usuarios'; // Nombre de la tabla en la base de datos
    protected $primaryKey = 'Id_Usuario'; // Clave primaria de la tabla

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'Primer_Nombre',
        'Segundo_Nombre',
        'Primer_Apellido',
        'Segundo_Apellido',
        'Id_Documento',
        'Id_Estado',
        'Num_Documento',
        'Fecha_Nacimiento',
        'Id_L_Nacimiento',
        'Id_Genero',
        'Id_Rol',
        'Id_Contacto',
        'Id_Especialidad',
        'email', // Agregado desde el modelo User
        'email_verified_at', // Agregado desde el modelo User
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'Fecha_Nacimiento' => 'date',
        'email_verified_at' => 'datetime', // Agregado desde el modelo User
        'password' => 'hashed',
    ];

    /**
     * Verifica si el usuario tiene un rol específico.
     *
     * @param string $rolNombre
     * @return bool
     */
    public function tieneRol($rolNombre)
    {
        return $this->rol()->exists() && $this->rol->Rol === $rolNombre;
    }

    /**
     * Obtener el nombre completo del usuario.
     */
    public function getNombreCompletoAttribute()
    {
        return $this->Primer_Nombre . ' ' . $this->Primer_Apellido;
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'email'; // Cambiado a 'email' para usarlo como identificador de inicio de sesión
    }

    // Relaciones
    public function rol()
    {
        return $this->belongsTo(Rol::class, 'Id_Rol');
    }

    public function documento()
    {
        return $this->belongsTo(DocumentoIdentificacion::class, 'Id_Documento');
    }

    public function estado()
    {
        return $this->belongsTo(Estado::class, 'Id_Estado');
    }

    public function lugarNacimiento()
    {
        return $this->belongsTo(LugarNacimiento::class, 'Id_L_Nacimiento');
    }

    public function genero()
    {
        return $this->belongsTo(Genero::class, 'Id_Genero');
    }

    public function contacto()
    {
        return $this->belongsTo(Contacto::class, 'Id_Contacto');
    }

    public function especialidad()
    {
        return $this->belongsTo(Especialidad::class, 'Id_Especialidad');
    }

    public function cursos()
    {
        return $this->hasMany(Curso::class, 'Id_Usuario');
    }

    public function inscripciones()
    {
        return $this->hasMany(Inscripcion::class, 'Id_Usuario');
    }

    public function evaluaciones()
    {
        return $this->hasMany(Evaluacion::class, 'Id_Usuario');
    }

    public function notasFinales()
    {
        return $this->hasMany(NotaFinal::class, 'Id_Usuario');
    }
}