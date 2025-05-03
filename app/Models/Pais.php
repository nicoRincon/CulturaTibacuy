<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pais extends Model
{
    use HasFactory;

    protected $table = 'País';
    protected $primaryKey = 'Id_País';
    public $timestamps = false;

    protected $fillable = [
        'País',
    ];

    public function departamentos()
    {
        return $this->hasMany(Departamento::class, 'Id_País');
    }

    public function municipios()
    {
        return $this->hasMany(Municipio::class, 'Id_País');
    }

    public function lugaresNacimiento()
    {
        return $this->hasMany(LugarNacimiento::class, 'Id_País');
    }
}
