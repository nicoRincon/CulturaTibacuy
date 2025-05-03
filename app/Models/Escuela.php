<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Escuela extends Model
{
    use HasFactory;

    protected $table = 'Escuelas';
    protected $primaryKey = 'Id_Escuela';
    public $timestamps = false;

    protected $fillable = [
        'Nombre',
        'Descripcion',
    ];

    public function programas()
    {
        return $this->hasMany(ProgramaFormacion::class, 'Id_Escuela');
    }
}