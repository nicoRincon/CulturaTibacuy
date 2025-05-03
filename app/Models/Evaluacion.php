<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluacion extends Model
{
    use HasFactory;

    protected $table = 'Evaluaciones';
    protected $primaryKey = 'Id_Evaluacion';
    public $timestamps = false;

    protected $fillable = [
        'Id_Usuario',
        'Id_Curso',
        'Fecha_Evaluacion',
        'Nota',
        'Comentarios',
    ];

    protected $dates = [
        'Fecha_Evaluacion',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'Id_Usuario');
    }

    public function curso()
    {
        return $this->belongsTo(Curso::class, 'Id_Curso');
    }
}
