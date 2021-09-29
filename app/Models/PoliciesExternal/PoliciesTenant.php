<?php

namespace App\Models\PoliciesExternal;

use Illuminate\Database\Eloquent\Model;

class PoliciesTenant extends Model
{
    protected $connection   = 'comments';
    protected $table        = 'inquilino_poliza';
    protected $primaryKey   = 'id';
    protected $fillable     = [
        'inquilino_tipo', 
        'inquilino',
        'poliza'
    ];
}
