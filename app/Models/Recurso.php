<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recurso extends Model
{
    use HasFactory;

    protected $table = 'recursos';
    protected $primaryKey = 'id_recurso';
    public $timestamps = false;

    protected $fillable = [
        'recurso',
    ];

    public function cursos()
    {
        return $this->hasMany(Curso::class, 'id_recurso');
    }
}
