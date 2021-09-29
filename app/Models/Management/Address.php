<?php

namespace App\Models\Management;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table        = 'address';
    protected $primaryKey   = 'id';
    protected $fillable     = [
        'address', 
        'exterior', 
        'interior', 
        'colonia', 
        'postal_code', 
        'status',
        'created_at', 
        'updated_at',
        'municipality_id', 
        'user_id',
        'id_user'
    ];
    protected $hidden = [
        'created_at', 
        'updated_at',
        'user_id',
        'id_user'
    ];

    public function municipality() {
        return $this->hasOne('App\Models\Settings\Municipalities', 'id', 'municipality_id');
    }
    
    public function user() {
        return $this->hasOne('App\Models\Settings\User', 'id', 'user_id');
    }
    
    public function contact() {
        return $this->belongTo('App\Models\Management\Contacts');
    }
    
    public function signer() {
        return $this->belongTo('App\Models\Management\Signers');
    }
    
    public function property() {
        return $this->belongTo('App\Models\Management\Properties');
    }
}
