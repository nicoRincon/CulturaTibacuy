<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LugarNacimiento extends Model
{
    use HasFactory;

    protected $table = 'Lugar_de_Nacimiento';
    protected $primaryKey = 'Id_L_Nacimiento';
    public $timestamps = false;

    protected $fillable = [
        'Id_País',
        'Id_Dpto',
        'Id_Mpio',
    ];

    public function pais()
    {
        return $this->belongsTo(Pais::class, 'Id_País');
    }

    public function departamento()
    {
        return $this->belongsTo(Departamento::class, 'Id_Dpto');
    }

    public function municipio()
    {
        return $this->belongsTo(Municipio::class, 'Id_Mpio');
    }

    public function usuarios()
    {
        return $this->hasMany(Usuario::class, 'Id_L_Nacimiento');
    }
}
