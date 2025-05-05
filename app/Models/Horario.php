<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    use HasFactory;

    protected $table = 'Horarios';
    protected $primaryKey = 'Id_Horario';
    public $timestamps = false;

    protected $fillable = [
        'Dia',
        'Hora_Inicio',
        'Hora_Fin',
    ];

    public function cursos()
    {
        return $this->hasMany(Curso::class, 'Id_Horario');
    }
}
