<?php

namespace App\Models\PoliciesExternal;

use Illuminate\Database\Eloquent\Model;

class CountFolio extends Model
{
    protected $connection   = 'comments';
    protected $table        = 'count_folio';
    protected $primaryKey   = 'id';
    protected $fillable     = [
        'count', 
    ];
}
