<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Model;

class Municipalities extends Model
{
    protected $table        = 'municipalities';
    protected $primaryKey   = 'id';
    protected $fillable     = [
        'name', 
        'abbreviation', 
        'status',
        'created_at', 
        'updated_at',
        'state_id'
    ];
    protected $hidden = [
        'created_at', 
        'updated_at'
    ];

    public function state() {
        return $this->hasOne('App\Models\Settings\States', 'id', 'state_id');
    }
}
