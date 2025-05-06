<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistorialCambio extends Model
{
    use HasFactory;

    protected $table = 'historial_de_cambios';
    protected $primaryKey = 'id_historial';
    public $timestamps = false;

    protected $fillable = [
        'tabla',
        'id_registro',
        'campo',
        'dato_anterior',
        'dato_nuevo',
        'fecha_cambio',
        'id_usuario',
    ];

    protected $dates = [
        'fecha_cambio',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }
}
