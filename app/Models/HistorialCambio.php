<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistorialCambio extends Model
{
    use HasFactory;

    protected $table = 'Historial_de_Cambios';
    protected $primaryKey = 'Id';
    public $timestamps = false;

    protected $fillable = [
        'Tabla',
        'Id_Registro',
        'Campo',
        'Dato_Anterior',
        'Dato_Nuevo',
        'Fecha_Cambio',
        'Id_Usuario',
    ];

    protected $dates = [
        'Fecha_Cambio',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'Id_Usuario');
    }
}
