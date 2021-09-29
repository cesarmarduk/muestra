<?php

namespace App\Models\PoliciesExternal;

use Illuminate\Database\Eloquent\Model;

class PoliciesProCompany extends Model
{
    protected $connection   = 'comments';
    protected $table        = 'propietario_empresa';
    protected $primaryKey   = 'id';
    protected $fillable     = [
        'empresa', 
    ];
}
