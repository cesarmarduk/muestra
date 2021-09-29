<?php

namespace App\Models\PoliciesExternal;

use Illuminate\Database\Eloquent\Model;

class PoliciesGuarantor extends Model
{
    protected $connection   = 'comments';
    protected $table        = 'garante_poliza';
    protected $primaryKey   = 'id';
    protected $fillable     = [
        'garante_tipo', 
        'garante',
        'poliza'
    ];
}
