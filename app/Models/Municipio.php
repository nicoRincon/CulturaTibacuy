<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Municipio extends Model
{
    use HasFactory;

    protected $table = 'Municipios';
    protected $primaryKey = 'Id_Mpio';
    public $timestamps = false;

    protected $fillable = [
        'Id_País',
        'Id_Dpto',
        'Municipio',
    ];

    public function pais()
    {
        return $this->belongsTo(Pais::class, 'Id_País');
    }

    public function departamento()
    {
        return $this->belongsTo(Departamento::class, 'Id_Dpto');
    }

    public function lugaresNacimiento()
    {
        return $this->hasMany(LugarNacimiento::class, 'Id_Mpio');
    }
}