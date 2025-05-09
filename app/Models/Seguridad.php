<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seguridad extends Model
{
    use HasFactory;

    protected $table = 'seguridad';
    protected $primaryKey = 'id_seguridad';
    public $timestamps = false;

    protected $fillable = [
        'id_usuario',
        'accion',
        'fecha',
    ];

    protected $dates = [
        'fecha',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }
}