<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Especialidad extends Model
{
    use HasFactory;

    protected $table = 'Especialidades';
    protected $primaryKey = 'Id_Especialidad';
    public $timestamps = false;

    protected $fillable = [
        'Especialidad',
    ];

    public function usuarios()
    {
        return $this->hasMany(Usuario::class, 'Id_Especialidad');
    }
}
