<?php

namespace App\Models\Management;

use Illuminate\Database\Eloquent\Model;

class PoliciesSignersJob extends Model
{
    protected $table        = 'policies_signers_job';
    protected $primaryKey   = 'id';
    protected $fillable     = [
        'name', 
        'email', 
        'phone',
        'address',
        'created_at', 
        'updated_at',
        'policy_id', 
        'signer_id',
    ];
    protected $hidden = [
        'created_at', 
        'updated_at'
    ];

    public function policy() {
        return $this->hasOne('App\Models\Management\Policies', 'id', 'policy_id');
    }
    
    public function signer() {
        return $this->hasOne('App\Models\Management\Signers', 'id', 'signer_id');
    }
}
