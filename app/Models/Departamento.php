<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    use HasFactory;

    protected $table = 'departamentos';
    protected $primaryKey = 'id_dpto';
    public $timestamps = false;

    protected $fillable = [
        'id_pais',
        'departamento',
    ];

    public function pais()
    {
        return $this->belongsTo(Pais::class, 'id_pais');
    }

    public function municipios()
    {
        return $this->hasMany(Municipio::class, 'id_dpto');
    }

    public function lugaresNacimiento()
    {
        return $this->hasMany(LugarNacimiento::class, 'id_dpto');
    }
}