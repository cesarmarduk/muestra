<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Model;

class Templates extends Model
{
    protected $table        = 'templates';
    protected $primaryKey   = 'id';
    protected $fillable     = [
        'code', 
        'name', 
        'template', 
        'status',
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
        return $this->hasOne('App\Models\Settings\User');
    }
}
