<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentoIdentificacion extends Model
{
    use HasFactory;

    protected $table = 'Documento_de_Identificacion';
    protected $primaryKey = 'Id_Documento';
    public $timestamps = false;

    protected $fillable = [
        'Tipo_Documento',
    ];

    public function usuarios()
    {
        return $this->hasMany(Usuario::class, 'Id_Documento');
    }
}