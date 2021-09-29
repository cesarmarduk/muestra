<?php

namespace App\Models\Management;

use Illuminate\Database\Eloquent\Model;

class ContratsSigners extends Model
{
    protected $table        = 'contrats_signers';
    protected $primaryKey   = 'id';
    protected $fillable     = [
        'type', 
        'status',
        'created_at', 
        'updated_at',
        'contrat_id', 
        'signer_id', 
        'notarial_id'
    ];
    protected $hidden = [
        'created_at', 
        'updated_at'
    ];

    public function contrat() {
        return $this->hasOne('App\Models\Management\Contrats', 'id', 'contrat_id');
    }
    
    public function signer() {
        return $this->hasOne('App\Models\Management\Signers', 'id', 'signer_id');
    }
    
    public function notarial() {
        return $this->hasOne('App\Models\Management\Notarials', 'id', 'notarial_id');
    }
}
