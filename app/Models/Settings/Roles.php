<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    protected $table        = 'roles';
    protected $primaryKey   = 'id';
    protected $fillable     = [
        'name', 
        'guard_name', 
        'created_at', 
        'updated_at'
    ];
    protected $hidden = [
        'created_at', 
        'updated_at'
    ];
}
