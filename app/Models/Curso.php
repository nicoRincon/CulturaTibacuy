<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    use HasFactory;

    protected $table = 'cursos';
    protected $primaryKey = 'id_curso';
    public $timestamps = false;

    protected $fillable = [
        'curso',
        'id_recurso',
        'id_horario',
        'fecha_inicio',
        'fecha_fin',
        'objetivo',
        'id_nivel',
        'cupos',
        'cantidad_alumnos',
        'id_usuario', // Instructor
    ];

    protected $dates = [
        'fecha_inicio',
        'fecha_fin',
    ];

    public function recurso()
    {
        return $this->belongsTo(Recurso::class, 'id_recurso');
    }

    public function horario()
    {
        return $this->belongsTo(Horario::class, 'id_horario');
    }

    public function nivel()
    {
        return $this->belongsTo(Nivel::class, 'id_nivel');
    }

    public function instructor()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }

    public function inscripciones()
    {
        return $this->hasMany(Inscripcion::class, 'id_curso');
    }

    public function evaluaciones()
    {
        return $this->hasMany(Evaluacion::class, 'id_curso');
    }

    public function notasFinales()
    {
        return $this->hasMany(NotaFinal::class, 'id_curso');
    }

    public function programas()
    {
        return $this->hasMany(ProgramaFormacion::class, 'id_curso');
    }

    public function cuposDisponibles()
    {
        return $this->cupos - $this->cantidad_alumnos;
    }

    public function tieneDisponibilidad()
    {
        return $this->cuposDisponibles() > 0;
    }
}
