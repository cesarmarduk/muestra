<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Model;

class PoliciesPrice extends Model
{
    protected $table        = 'policies_price';
    protected $primaryKey   = 'id';
    protected $fillable     = [
        'price', 
        'price_type', 
        'price_beginning', 
        'price_finish', 
        'policy_type_id', 
        'created_at', 
        'updated_at'
    ];
    protected $hidden = [
        'created_at', 
        'updated_at'
    ];

    public function policy_type() {
        return $this->hasOne('App\Models\Settings\PoliciesType', 'id', 'policy_type_id');
    }
}
