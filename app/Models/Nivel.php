<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nivel extends Model
{
    use HasFactory;

    protected $table = 'Niveles';
    protected $primaryKey = 'Id_Nivel';
    public $timestamps = false;

    protected $fillable = [
        'Nivel',
    ];

    public function cursos()
    {
        return $this->hasMany(Curso::class, 'Id_Nivel');
    }
}
