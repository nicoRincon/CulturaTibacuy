<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recurso extends Model
{
    use HasFactory;

    protected $table = 'Recursos';
    protected $primaryKey = 'Id_Recurso';
    public $timestamps = false;

    protected $fillable = [
        'Recurso',
    ];

    public function cursos()
    {
        return $this->hasMany(Curso::class, 'Id_Recurso');
    }
}
