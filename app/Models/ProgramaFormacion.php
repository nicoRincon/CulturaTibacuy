<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramaFormacion extends Model
{
    use HasFactory;

    protected $table = 'Programa_De_formación';
    protected $primaryKey = 'Id_Programa';
    public $timestamps = false;

    protected $fillable = [
        'Id_Tipo_Escuela',
        'Id_Escuela',
        'Id_Ubicacion',
        'Id_Curso',
        'Id_Usuario',
    ];

    public function tipoEscuela()
    {
        return $this->belongsTo(TipoEscuela::class, 'Id_Tipo_Escuela');
    }

    public function escuela()
    {
        return $this->belongsTo(Escuela::class, 'Id_Escuela');
    }

    public function ubicacion()
    {
        return $this->belongsTo(Ubicacion::class, 'Id_Ubicacion');
    }

    public function curso()
    {
        return $this->belongsTo(Curso::class, 'Id_Curso');
    }

    public function responsable()
    {
        return $this->belongsTo(Usuario::class, 'Id_Usuario');
    }
}