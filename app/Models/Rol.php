<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    use HasFactory;

    protected $table = 'Roles';
    protected $primaryKey = 'Id_Rol';
    public $timestamps = false;

    protected $fillable = [
        'Rol',
    ];

    public function usuarios()
    {
        return $this->hasMany(Usuario::class, 'Id_Rol');
    }

    public function permisos()
    {
        return $this->belongsToMany(Permiso::class, 'Roles_Permisos', 'Id_Rol', 'Id_Permiso')
            ->withPivot('Fecha_Asignacion');
    }
}
