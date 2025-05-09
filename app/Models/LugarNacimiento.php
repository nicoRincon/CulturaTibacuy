<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LugarNacimiento extends Model
{
    use HasFactory;

    protected $table = 'lugar_de_nacimiento';
    protected $primaryKey = 'id_lugar_nacimiento';
    public $timestamps = false;

    protected $fillable = [
        'id_pais',
        'id_dpto',
        'id_mpio',
    ];

    public function pais()
    {
        return $this->belongsTo(Pais::class, 'id_pais');
    }

    public function departamento()
    {
        return $this->belongsTo(Departamento::class, 'id_dpto');
    }

    public function municipio()
    {
        return $this->belongsTo(Municipio::class, 'id_mpio');
    }

    public function usuarios()
    {
        return $this->hasMany(User::class, 'id_lugar_nacimiento');
    }
}
