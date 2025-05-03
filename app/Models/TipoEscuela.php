<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoEscuela extends Model
{
    use HasFactory;

    protected $table = 'Tipos_Escuela';
    protected $primaryKey = 'Id_Tipo_Escuela';
    public $timestamps = false;

    protected $fillable = [
        'Tipos_Escuela',
    ];

    public function programas()
    {
        return $this->hasMany(ProgramaFormacion::class, 'Id_Tipo_Escuela');
    }
}