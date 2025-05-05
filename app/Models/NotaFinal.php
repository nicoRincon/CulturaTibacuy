<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotaFinal extends Model
{
    use HasFactory;

    protected $table = 'Nota_Final';
    protected $primaryKey = 'Id_Nota_Final';
    public $timestamps = false;

    protected $fillable = [
        'Id_Usuario',
        'Id_Curso',
        'Nota_Final',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'Id_Usuario');
    }

    public function curso()
    {
        return $this->belongsTo(Curso::class, 'Id_Curso');
    }
}
