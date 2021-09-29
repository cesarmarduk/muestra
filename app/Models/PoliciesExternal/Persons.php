<?php

namespace App\Models\PoliciesExternal;

use Illuminate\Database\Eloquent\Model;

class Persons extends Model
{
    protected $connection   = 'comments';
    protected $table        = 'persona';
    protected $primaryKey   = 'id';
    protected $fillable     = [
        'nombre',
        'correo',
        'telefono',
        'direccion',
    ];
}
