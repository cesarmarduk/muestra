<?php

namespace App\Models\Management;

use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{
    protected $table        = 'payments';
    protected $primaryKey   = 'id';
    protected $fillable     = [
        'date_payment',
        'payment_type',
        'order_id',
        'token_id',
        'amount',
        'status',
        'type',
        'created_at', 
        'updated_at',
        'contrat_id',  
        'user_id'
    ];
    protected $hidden = [
        'created_at', 
        'updated_at',
        'user_id'
    ];

    public function contrat() {
        return $this->hasOne('App\Models\Management\Contrats', 'id', 'contrat_id');
    }

    public function user() {
        return $this->hasOne('App\Models\Settings\User', 'id', 'user_id');
    }
}
