<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pais extends Model
{
    use HasFactory;

    protected $table = 'Pais';
    protected $primaryKey = 'Id_Pais';
    public $timestamps = false;

    protected $fillable = [
        'Pais',
    ];

    public function departamentos()
    {
        return $this->hasMany(Departamento::class, 'Id_Pais');
    }

    public function municipios()
    {
        return $this->hasMany(Municipio::class, 'Id_Pais');
    }

    public function lugaresNacimiento()
    {
        return $this->hasMany(LugarNacimiento::class, 'Id_Pais');
    }
}
