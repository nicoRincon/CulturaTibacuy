<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    use HasFactory;

    protected $table = 'Cursos';
    protected $primaryKey = 'Id_Curso';
    public $timestamps = false;

    protected $fillable = [
        'Curso',
        'Id_Recurso',
        'Id_Horario',
        'Fecha_Inicio',
        'Fecha_Fin',
        'Objetivo',
        'Id_Nivel',
        'Cupos',
        'Cantidad_Alumnos',
        'Id_Usuario', // Instructor
    ];

    protected $dates = [
        'Fecha_Inicio',
        'Fecha_Fin',
    ];

    public function recurso()
    {
        return $this->belongsTo(Recurso::class, 'Id_Recurso');
    }

    public function horario()
    {
        return $this->belongsTo(Horario::class, 'Id_Horario');
    }

    public function nivel()
    {
        return $this->belongsTo(Nivel::class, 'Id_Nivel');
    }

    public function instructor()
    {
        return $this->belongsTo(Usuario::class, 'Id_Usuario');
    }

    public function inscripciones()
    {
        return $this->hasMany(Inscripcion::class, 'Id_Curso');
    }

    public function evaluaciones()
    {
        return $this->hasMany(Evaluacion::class, 'Id_Curso');
    }

    public function notasFinales()
    {
        return $this->hasMany(NotaFinal::class, 'Id_Curso');
    }

    public function programas()
    {
        return $this->hasMany(ProgramaFormacion::class, 'Id_Curso');
    }

    public function cuposDisponibles()
    {
        return $this->Cupos - $this->Cantidad_Alumnos;
    }

    public function tieneDisponibilidad()
    {
        return $this->cuposDisponibles() > 0;
    }
}
