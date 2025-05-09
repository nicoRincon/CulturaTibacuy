<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoEscuela extends Model
{
    use HasFactory;

    protected $table = 'tipos_escuela';
    protected $primaryKey = 'id_tipo_escuela';
    public $timestamps = false;

    protected $fillable = [
        'tipos_escuela',
    ];

    public function programas()
    {
        return $this->hasMany(ProgramaFormacion::class, 'id_tipo_escuela');
    }
}