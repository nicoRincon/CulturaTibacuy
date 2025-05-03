<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inscripcion extends Model
{
    use HasFactory;

    protected $table = 'Inscripciones';
    protected $primaryKey = 'Id_Inscripcion';
    public $timestamps = false;

    protected $fillable = [
        'Id_Usuario',
        'Id_Curso',
        'Fecha_Inscripcion',
    ];

    protected $dates = [
        'Fecha_Inscripcion',
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
