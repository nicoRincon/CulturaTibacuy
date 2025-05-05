<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListaEspera extends Model
{
    use HasFactory;

    protected $table = 'Lista_de_Espera';
    protected $primaryKey = 'Id_Lista_Espera';
    public $timestamps = false;

    protected $fillable = [
        'Id_Usuario',
        'Id_Curso',
        'Fecha_Solicitud',
    ];

    protected $dates = [
        'Fecha_Solicitud',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'Id_Usuario');
    }

    public function curso()
    {
        return $this->belongsTo(Curso::class, 'Id_Curso');
    }
}