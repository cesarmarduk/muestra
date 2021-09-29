<?php

namespace App\Models\PoliciesExternal;

use Illuminate\Database\Eloquent\Model;

class PoliciesProperties extends Model
{
    protected $connection   = 'comments';
    protected $table        = 'propietario_inmueble';
    protected $primaryKey   = 'id';
    protected $fillable     = [
        'propietario_tipo', 
        'propietario',
        'inmueble'
    ];
}
