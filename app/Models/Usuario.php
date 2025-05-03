<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Usuario extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'Usuarios';
    protected $primaryKey = 'Id_Usuario';

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
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Relaciones
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

    public function rol()
    {
        return $this->belongsTo(Rol::class, 'Id_Rol');
    }

    public function contacto()
    {
        return $this->belongsTo(Contacto::class, 'Id_Contacto');
    }

    public function especialidad()
    {
        return $this->belongsTo(Especialidad::class, 'Id_Especialidad');
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

    // Para instructores
    public function cursos()
    {
        return $this->hasMany(Curso::class, 'Id_Usuario');
    }

    public function tieneRol($rolNombre)
    {
        return $this->rol->Rol === $rolNombre;
    }
}