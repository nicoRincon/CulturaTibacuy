<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pais extends Model
{
    use HasFactory;

    protected $table = 'pais';
    protected $primaryKey = 'id_pais';
    public $timestamps = false;

    protected $fillable = [
        'pais',
    ];

    public function departamentos()
    {
        return $this->hasMany(Departamento::class, 'id_pais');
    }

    public function municipios()
    {
        return $this->hasMany(Municipio::class, 'id_pais');
    }

    public function lugaresNacimiento()
    {
        return $this->hasMany(LugarNacimiento::class, 'id_pais');
    }
}
