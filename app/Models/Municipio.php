<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Municipio extends Model
{
    use HasFactory;

    protected $table = 'municipios';
    protected $primaryKey = 'id_mpio';
    public $timestamps = false;

    protected $fillable = [
        'id_pais',
        'id_dpto',
        'municipio',
    ];

    public function pais()
    {
        return $this->belongsTo(Pais::class, 'id_pais');
    }

    public function departamento()
    {
        return $this->belongsTo(Departamento::class, 'id_dpto');
    }

    public function lugaresNacimiento()
    {
        return $this->hasMany(LugarNacimiento::class, 'id_mpio');
    }
}