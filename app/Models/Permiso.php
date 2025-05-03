<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permiso extends Model
{
    use HasFactory;

    protected $table = 'Permisos';
    protected $primaryKey = 'Id_Permiso';
    public $timestamps = false;

    protected $fillable = [
        'Permiso',
        'Descripcion',
    ];

    public function roles()
    {
        return $this->belongsToMany(Rol::class, 'Roles_Permisos', 'Id_Permiso', 'Id_Rol')
            ->withPivot('Fecha_Asignacion');
    }
}
