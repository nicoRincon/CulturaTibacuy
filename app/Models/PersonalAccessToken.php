<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalAccessToken extends Model
{
    use HasFactory;

    /**
     * La tabla asociada al modelo.
     *
     * @var string
     */
    protected $table = 'personal_access_tokens';

    /**
     * Los atributos que se pueden asignar de forma masiva.
     *
     * @var array
     */
    protected $fillable = [
        'tokenable_type',
        'tokenable_id',
        'name',
        'token',
        'abilities',
        'last_used_at',
        'expires_at',
    ];

    /**
     * Los atributos que deben ser tratados como fechas.
     *
     * @var array
     */
    protected $dates = [
        'last_used_at',
        'expires_at',
    ];

    /**
     * Relación polimórfica con el modelo tokenable.
     */
    public function tokenable()
    {
        return $this->morphTo();
    }
}