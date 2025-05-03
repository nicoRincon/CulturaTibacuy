<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    use HasFactory;

    protected $table = 'Departamentos';
    protected $primaryKey = 'Id_Dpto';
    public $timestamps = false;

    protected $fillable = [
        'Id_País',
        'Departamento',
    ];

    public function pais()
    {
        return $this->belongsTo(Pais::class, 'Id_País');
    }

    public function municipios()
    {
        return $this->hasMany(Municipio::class, 'Id_Dpto');
    }

    public function lugaresNacimiento()
    {
        return $this->hasMany(LugarNacimiento::class, 'Id_Dpto');
    }
}