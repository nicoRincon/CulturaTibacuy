<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'usuarios';
    protected $primaryKey = 'id_usuario';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'primer_nombre',
        'segundo_nombre',
        'primer_apellido',
        'segundo_apellido',
        'id_documento',
        'id_estado',
        'num_documento',
        'fecha_nacimiento',
        'id_lugar_nacimiento',
        'id_genero',
        'id_rol',
        'id_contacto',
        'id_especialidad',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Verifica si el usuario tiene un rol específico.
     *
     * @param string $rol_nombre
     * @return bool
     */
    public function tieneRol($rol_nombre)
    {
        return $this->rol()->exists() && $this->rol->rol === $rol_nombre;
    }

    /**
     * Obtener el nombre completo del usuario.
     */
    public function getNombreCompletoAttribute()
    {
        return $this->primer_nombre . ' ' . $this->primer_apellido;
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

    // Relaciones
    public function rol()
    {
        return $this->belongsTo(Rol::class, 'id_rol');
    }

    public function documento()
    {
        return $this->belongsTo(DocumentoIdentificacion::class, 'id_documento');
    }

    public function estado()
    {
        return $this->belongsTo(Estado::class, 'id_estado');
    }

    public function lugarNacimiento()
    {
        return $this->belongsTo(LugarNacimiento::class, 'id_lugar_nacimiento');
    }

    public function genero()
    {
        return $this->belongsTo(Genero::class, 'id_genero');
    }

    public function contacto()
    {
        return $this->belongsTo(Contacto::class, 'id_contacto');
    }

    public function especialidad()
    {
        return $this->belongsTo(Especialidad::class, 'id_especialidad');
    }

    public function cursos()
    {
        return $this->hasMany(Curso::class, 'id_usuario');
    }

    public function inscripciones()
    {
        return $this->hasMany(Inscripcion::class, 'id_usuario');
    }

    public function evaluaciones()
    {
        return $this->hasMany(Evaluacion::class, 'id_usuario');
    }

    public function notasFinales()
    {
        return $this->hasMany(NotaFinal::class, 'id_usuario');
    }

    // El método morphTo para Sanctum probablemente necesita ser ajustado
    // Esto debería agregarse para que funcione correctamente con Sanctum
    public function tokens()
    {
        return $this->morphMany(
            PersonalAccessToken::class, 
            'tokenable', 
            'tokenable_type', 
            'id_usuario'
        );
    }
}
