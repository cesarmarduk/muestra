<?php

namespace App\Models\PoliciesExternal;

use Illuminate\Database\Eloquent\Model;

class PoliciesGarCompany extends Model
{
    protected $connection   = 'comments';
    protected $table        = 'garante_moral';
    protected $primaryKey   = 'id';
    protected $fillable     = [
        'empresa', 
        'inmueble_garantia',
        'datos_notariales_inmueble_garantia'
    ];
}
