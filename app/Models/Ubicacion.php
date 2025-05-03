<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ubicacion extends Model
{
    use HasFactory;

    protected $table = 'Ubicaciones';
    protected $primaryKey = 'Id_Ubicacion';
    public $timestamps = false;

    protected $fillable = [
        'Ubicación',
    ];

    public function programas()
    {
        return $this->hasMany(ProgramaFormacion::class, 'Id_Ubicacion');
    }
}
