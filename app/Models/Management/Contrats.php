<?php

namespace App\Models\Management;

use Illuminate\Database\Eloquent\Model;

class Contrats extends Model
{
    protected $table        = 'contrats';
    protected $primaryKey   = 'id';
    protected $dates = ['created_at', 
    'updated_at'];
    protected $fillable     = [
        'type', 
        'has_extincion',
        'has_sign',
        'date_beginning', 
        'date_finish', 
        'rent_monthly', 
        'payment_beginning', 
        'payment_finish', 
        'deposit', 
        'bank_institution', 
        'bank_titular', 
        'bank_account', 
        'bank_clabe', 
        'use', 
        'created_at', 
        'updated_at',
        'property_id', 
        'file_id', 
        'user_id',
        'sign_status',
        'id_user'
    ];
    protected $hidden = [
        'created_at', 
        'updated_at',
        'user_id',
        'id_user'
    ];

    public function property() {
        return $this->hasOne('App\Models\Management\Properties', 'id', 'property_id');
    }
    
    public function file() {
        return $this->hasOne('App\Models\Files', 'id', 'file_id');
    }

    public function user() {
        return $this->hasOne('App\Models\Settings\User', 'id', 'user_id');
    }

    public function contrat_signers() {
        return $this->hasMany('App\Models\Management\ContratsSigners', 'contrat_id', 'id')->orderBy('type','ASC');
    }
}
