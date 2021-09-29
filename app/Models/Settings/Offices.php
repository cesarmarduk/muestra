<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Model;

class Offices extends Model
{
    protected $table        = 'offices';
    protected $primaryKey   = 'id';
    protected $fillable     = [
        'name', 
        'status',
        'created_at', 
        'updated_at',
        'municipality_id'
    ];
    protected $hidden = [
        'created_at', 
        'updated_at'
    ];

    public function state() {
        return $this->hasOne('App\Models\Settings\Municipalities', 'id', 'municipality_id');
    }
}
