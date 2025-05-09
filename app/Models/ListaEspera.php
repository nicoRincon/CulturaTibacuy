<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListaEspera extends Model
{
    use HasFactory;

    protected $table = 'lista_de_espera';
    protected $primaryKey = 'id_lista_espera';
    public $timestamps = false;

    protected $fillable = [
        'id_usuario',
        'id_curso',
        'fecha_solicitud',
    ];

    protected $dates = [
        'fecha_solicitud',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }

    public function curso()
    {
        return $this->belongsTo(Curso::class, 'id_curso');
    }
}