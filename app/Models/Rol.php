<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role as SpatieRole;

class Rol extends SpatieRole
{
    use HasFactory;

    protected $table = 'roles';
    protected $primaryKey = 'id_rol';
    
    // Spatie Permission usa 'name' por defecto, pero tu tabla usa 'rol'
    protected $fillable = [
        'rol',
        'guard_name',
    ];

    // Override para usar 'rol' en lugar de 'name'
    public function getNameAttribute()
    {
        return $this->attributes['rol'];
    }

    public function setNameAttribute($value)
    {
        $this->attributes['rol'] = $value;
    }

    public function usuarios()
    {
        return $this->hasMany(User::class, 'id_rol');
    }

    public function permisos()
    {
        return $this->belongsToMany(Permiso::class, 'roles_permisos', 'id_rol', 'id_permiso')
            ->withPivot('fecha_asignacion');
    }
}