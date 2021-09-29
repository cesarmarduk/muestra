<?php

namespace App\Models\Management;

use Illuminate\Database\Eloquent\Model;

class PoliciesSigners extends Model
{
    protected $table        = 'policies_signers';
    protected $primaryKey   = 'id';
    protected $fillable     = [
        'type', 
        'representative', 
        'created_at', 
        'updated_at',
        'policy_id', 
        'signer_id', 
        'notarial_id', 
        'representative_id', 
        'property_warranty_id'
    ];
    protected $hidden = [
        'created_at', 
        'updated_at'
    ];

    public function policy() {
        return $this->hasOne('App\Models\Management\Policies', 'id', 'policy_id');
    }
    
    public function signer() {
        return $this->hasOne('App\Models\Management\Signers', 'id', 'signer_id')->with(['address']);
    }
    
    public function notarial() {
        return $this->hasOne('App\Models\Management\Notarials', 'id', 'notarial_id');
    }
    
    public function representative() {
        return $this->hasOne('App\Models\Management\Representatives', 'id', 'representative_id');
    }
    
    public function property_warranty() {
        return $this->hasOne('App\Models\Management\PropertiesWarranty', 'id', 'property_warranty_id');
    }
}
