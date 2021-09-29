<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Model;

class PoliciesType extends Model
{
    protected $table        = 'policies_type';
    protected $primaryKey   = 'id';
    protected $fillable     = [
        'name', 
        'created_at', 
        'updated_at'
    ];
    protected $hidden = [
        'created_at', 
        'updated_at'
    ];

    public function policy() {
        return $this->belongTo('App\Models\Management\Policies', 'policy_type_id', 'id');
    }

    public function prices() {
        return $this->hasMany('App\Models\Settings\PoliciesPrice', 'policy_type_id', 'id');
    }
}
