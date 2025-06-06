<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;


class Contacto extends Model
{
    use HasFactory;

    protected $table = 'contactos';
    protected $primaryKey = 'id_contacto';
    public $timestamps = false;

    protected $fillable = [
        'telefono',
        'email',
        'direccion',
    ];

    public function usuarios()
    {
        return $this->hasMany(User::class, 'id_contacto');
    }
}
