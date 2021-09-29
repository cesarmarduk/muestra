<?php

namespace App\Models\Management;

use Illuminate\Database\Eloquent\Model;

class Properties extends Model
{
    protected $table        = 'properties';
    protected $primaryKey   = 'id';
    protected $fillable     = [
        'created_at', 
        'updated_at',
        'address_id', 
        'user_id',
        'id_user'
    ];
    protected $hidden = [
        'created_at', 
        'updated_at',
        'user_id',
        'id_user'
    ];

    public function address() {
        return $this->hasOne('App\Models\Management\Address', 'id', 'address_id');
    }

    public function user() {
        return $this->hasOne('App\Models\Settings\User', 'id', 'user_id');
    }
}
