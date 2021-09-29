<?php

namespace App\Models\Management;

use Illuminate\Database\Eloquent\Model;

class Policies extends Model
{
    protected $table        = 'policies';
    protected $primaryKey   = 'id';
    protected $fillable     = [
        'folio', 
        'type', 
        'date_beginning', 
        'date_finish', 
        'cost',  
        'rent_monthly', 
        'deposit', 
        'bank_institution', 
        'bank_titular', 
        'bank_account', 
        'bank_clabe', 
        'use', 
        'status',  
        'created_at', 
        'updated_at',
        'policy_type_id',  
        'contrat_id',  
        'property_id',  
        'user_id',  
        'id_user'
    ];
    protected $hidden = [
        'created_at', 
        'updated_at',
        'user_id',
        'id_user'
    ];

    public function policy_type() {
        return $this->hasOne('App\Models\Settings\PoliciesType', 'id', 'policy_type_id');
    }
    
    public function contrat() {
        return $this->hasOne('App\Models\Management\Contrats', 'id', 'contrat_id');
    }
    
    public function property() {
        return $this->hasOne('App\Models\Management\Properties', 'id', 'property_id');
    }
        
    public function user() {
        return $this->hasOne('App\Models\Settings\User', 'id', 'user_id');
    }

    public function policy_signers() {
        return $this->hasMany('App\Models\Management\PoliciesSigners', 'policy_id', 'id');
    }
    
    public function policy_signers_job() {
        return $this->hasOne('App\Models\Management\PoliciesSignersJob', 'policy_id', 'id');
    }
    
    public function policy_signers_reference() {
        return $this->hasOne('App\Models\Management\PoliciesSignersReferences', 'policy_id', 'id');
    }
    
    public function policy_files() {
        return $this->hasMany('App\Models\Management\PoliciesFiles', 'policy_id', 'id');
    }
}
