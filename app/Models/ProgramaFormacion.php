<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;

class ProgramaFormacion extends Model
{
    use HasFactory;

    protected $table = 'programa_de_formacion';
    protected $primaryKey = 'id_programa';
    public $timestamps = false;

    protected $fillable = [
        'id_tipo_escuela',
        'id_escuela',
        'id_ubicacion',
        'id_curso',
        'id_usuario',
    ];

    public function tipoEscuela()
    {
        return $this->belongsTo(TipoEscuela::class, 'id_tipo_escuela');
    }

    public function escuela()
    {
        return $this->belongsTo(Escuela::class, 'id_escuela');
    }

    public function ubicacion()
    {
        return $this->belongsTo(Ubicacion::class, 'id_ubicacion');
    }

    public function curso()
    {
        return $this->belongsTo(Curso::class, 'id_curso');
    }

    public function responsable()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }
}