<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class NotaFinal extends Model
{
    use HasFactory;

    protected $table = 'nota_final';
    protected $primaryKey = 'id_nota_final';
    public $timestamps = false;

    protected $fillable = [
        'id_usuario',
        'id_curso',
        'nota_final',
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
