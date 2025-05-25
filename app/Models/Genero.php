<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Genero extends Model
{
    use HasFactory;

    protected $table = 'generos';
    protected $primaryKey = 'id_genero';
    public $timestamps = false;

    protected $fillable = [
        'genero',
    ];

    public function usuarios()
    {
        return $this->hasMany(User::class, 'id_genero');
    }
}
