<?php

namespace App\Models\PoliciesExternal;

use Illuminate\Database\Eloquent\Model;

class ContratsEx extends Model
{
    protected $connection   = 'comments';
    protected $table        = 'contrato';
    protected $primaryKey   = 'id';
    protected $fillable     = [
        'fecha_inicio', 
        'fecha_termino', 
        'poliza', 
    ];
}
