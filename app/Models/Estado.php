<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    use HasFactory;

    protected $table = 'Estados';
    protected $primaryKey = 'Id_Estado';
    public $timestamps = false;

    protected $fillable = [
        'Estado',
    ];

    public function usuarios()
    {
        return $this->hasMany(Usuario::class, 'Id_Estado');
    }
}
