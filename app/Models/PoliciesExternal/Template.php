<?php

namespace App\Models\PoliciesExternal;

use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    protected $connection   = 'comments';
    protected $table        = 'plantilla';
    protected $primaryKey   = 'id';
    protected $fillable     = [
        'tipo_plantilla',
        'nombre',
        'texto'
    ];
}
