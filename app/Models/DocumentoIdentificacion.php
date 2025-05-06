<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentoIdentificacion extends Model
{
    use HasFactory;

    protected $table = 'documento_de_identificacion';
    protected $primaryKey = 'id_documento';
    public $timestamps = false;

    protected $fillable = [
        'tipo_documento',
    ];

    public function usuarios()
    {
        return $this->hasMany(User::class, 'id_documento');
    }
}