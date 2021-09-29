<?php

namespace App\Models\PoliciesExternal;

use Illuminate\Database\Eloquent\Model;

class PoliciesInqCompany extends Model
{
    protected $connection   = 'comments';
    protected $table        = 'inquilino_empresa';
    protected $primaryKey   = 'id';
    protected $fillable     = [
        'empresa', 
    ];
}
