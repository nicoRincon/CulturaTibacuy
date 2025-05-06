<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permiso extends Model
{
    use HasFactory;

    protected $table = 'permisos';
    protected $primaryKey = 'id_permiso';
    public $timestamps = false;

    protected $fillable = [
        'permiso',
        'descripcion',
    ];

    public function roles()
    {
        return $this->belongsToMany(Rol::class, 'roles_permisos', 'id_permiso', 'id_rol')
            ->withPivot('fecha_asignacion');
    }
}
