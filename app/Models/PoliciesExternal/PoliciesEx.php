<?php

namespace App\Models\PoliciesExternal;

use Illuminate\Database\Eloquent\Model;

class PoliciesEx extends Model
{
    protected $connection   = 'comments';
    protected $table        = 'poliza';
    protected $primaryKey   = 'id';
    protected $fillable     = [
        'fecha_inicio', 
        'fecha_termino', 
        'costo', 
        'folio',
        'solicitud',
        'tipo',
        'estado',
        'estado_pago',
        'estado_jurisdiccion',
        'externa_type',
        'externa_poliza_id',
        'externa_email',
        'has_sign',
        'inmueble'
    ];
}
