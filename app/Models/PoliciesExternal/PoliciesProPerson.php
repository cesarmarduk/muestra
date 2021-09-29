<?php

namespace App\Models\PoliciesExternal;

use Illuminate\Database\Eloquent\Model;

class PoliciesProPerson extends Model
{
    protected $connection   = 'comments';
    protected $table        = 'propietario_persona';
    protected $primaryKey   = 'id';
    protected $fillable     = [
        'persona'
    ];
}
