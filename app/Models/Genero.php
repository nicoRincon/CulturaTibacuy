<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genero extends Model
{
    use HasFactory;

    protected $table = 'Generos';
    protected $primaryKey = 'Id_Genero';
    public $timestamps = false;

    protected $fillable = [
        'Genero',
    ];

    public function usuarios()
    {
        return $this->hasMany(Usuario::class, 'Id_Genero');
    }
}
