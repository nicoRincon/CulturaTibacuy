<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Escuela extends Model
{
    use HasFactory;

    protected $table = 'escuelas';
    protected $primaryKey = 'id_escuela';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    public function programas()
    {
        return $this->hasMany(ProgramaFormacion::class, 'id_escuela');
    }
}