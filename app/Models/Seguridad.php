<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seguridad extends Model
{
    use HasFactory;

    protected $table = 'Seguridad';
    protected $primaryKey = 'Id';
    public $timestamps = false;

    protected $fillable = [
        'Id_Usuario',
        'Accion',
        'Fecha',
    ];

    protected $dates = [
        'Fecha',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'Id_Usuario');
    }
}