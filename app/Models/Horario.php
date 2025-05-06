<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    use HasFactory;

    protected $table = 'horarios';
    protected $primaryKey = 'id_horario';
    public $timestamps = false;

    protected $fillable = [
        'dia',
        'hora_inicio',
        'hora_fin',
    ];

    public function cursos()
    {
        return $this->hasMany(Curso::class, 'id_horario');
    }
}
