<?php

namespace App\Models\Management;

use Illuminate\Database\Eloquent\Model;

class PoliciesFiles extends Model
{
    protected $table        = 'policies_files';
    protected $primaryKey   = 'id';
    protected $fillable     = [
        'created_at', 
        'updated_at',
        'policy_id', 
        'signer_id', 
        'file_id',
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

    public function file() {
        return $this->hasOne('App\Models\Files', 'id', 'file_id');
    }
}
