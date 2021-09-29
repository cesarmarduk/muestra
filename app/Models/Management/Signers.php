<?php

namespace App\Models\Management;

use Illuminate\Database\Eloquent\Model;
use App\Models\Management\Address;

class Signers extends Model
{
    protected $table        = 'signers';
    protected $primaryKey   = 'id';
    protected $fillable     = [
        'company', 
        'rfc', 
        'name_repre', 
        'email_repre', 
        'phone_repre', 
        'name', 
        'email', 
        'email_comercia', 
        'phone', 
        'type', 
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
    
    public function contrat() {
        return $this->hasMany('App\Models\Management\ContratsSigners', 'signer_id', 'id');
    }
}
