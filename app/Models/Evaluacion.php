<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluacion extends Model
{
    use HasFactory;

    protected $table = 'evaluaciones';
    protected $primaryKey = 'id_evaluacion';
    public $timestamps = false;

    protected $fillable = [
        'id_usuario',
        'id_curso',
        'fecha_evaluacion',
        'nota',
        'comentarios',
    ];

    protected $dates = [
        'fecha_evaluacion',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }

    public function curso()
    {
        return $this->belongsTo(Curso::class, 'id_curso');
    }
}
