<?php

namespace App\Models\Management;

use Illuminate\Database\Eloquent\Model;

class Representatives extends Model
{
    protected $table        = 'representatives';
    protected $primaryKey   = 'id';
    protected $fillable     = [
        'first_name', 
        'last_name', 
        'email', 
        'phone', 
        'address', 
        'created_at', 
        'updated_at',
        'user_id',
        'id_user'
    ];
    protected $hidden = [
        'created_at', 
        'updated_at',
        'user_id',
        'id_user'
    ];

    public function user() {
        return $this->hasOne('App\Models\Settings\User', 'id', 'user_id');
    }
}
