<?php

namespace App\Models\PoliciesExternal;

use Illuminate\Database\Eloquent\Model;

class AddressEx extends Model
{
    protected $connection   = 'comments';
    protected $table        = 'direccion';
    protected $primaryKey   = 'id';
    protected $fillable     = [
        'direccion',
    ];
    protected $hidden = [
        'created_at', 
        'updated_at'
    ];
}
