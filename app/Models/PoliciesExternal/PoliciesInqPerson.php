<?php

namespace App\Models\PoliciesExternal;

use Illuminate\Database\Eloquent\Model;

class PoliciesInqPerson extends Model
{
    protected $connection   = 'comments';
    protected $table        = 'inquilino_persona';
    protected $primaryKey   = 'id';
    protected $fillable     = [
        'persona'
    ];
}
