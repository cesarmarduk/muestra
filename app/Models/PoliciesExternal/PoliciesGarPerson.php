<?php

namespace App\Models\PoliciesExternal;

use Illuminate\Database\Eloquent\Model;

class PoliciesGarPerson extends Model
{
    protected $connection   = 'comments';
    protected $table        = 'garante_fisico';
    protected $primaryKey   = 'id';
    protected $fillable     = [
        'persona',
        'datos_notariales_inmueble_garantia'
    ];
}
