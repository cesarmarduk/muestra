<?php

namespace App\Models\PoliciesExternal;

use Illuminate\Database\Eloquent\Model;

class Companies extends Model
{
    protected $connection   = 'comments';
    protected $table        = 'empresa';
    protected $primaryKey   = 'id';
    protected $fillable     = [
        'nombre',
        'rfc',
        'correo',
        'telefono',
        'direccion'
    ];
}
