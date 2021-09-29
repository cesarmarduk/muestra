<?php

namespace App\Models\PoliciesExternal;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    protected $connection   = 'comments';
    protected $table        = 'inmueble';
    protected $primaryKey   = 'id';
    protected $fillable     = [
        'monto_renta',
        'deposito',
        'uso',
        'institucion',
        'num_cuenta',
        'titular',
        'clabe',
        'direccion',
    ];
}
