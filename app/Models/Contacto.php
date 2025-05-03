<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contacto extends Model
{
    use HasFactory;

    protected $table = 'Contactos';
    protected $primaryKey = 'Id_Contacto';
    public $timestamps = false;

    protected $fillable = [
        'Telefono',
        'Correo',
        'Direccion',
    ];

    public function usuarios()
    {
        return $this->hasMany(Usuario::class, 'Id_Contacto');
    }
}
