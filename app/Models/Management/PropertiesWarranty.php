<?php

namespace App\Models\Management;

use Illuminate\Database\Eloquent\Model;

class PropertiesWarranty extends Model
{
    protected $table        = 'properties_warranty';
    protected $primaryKey   = 'id';
    protected $fillable     = [
        'address', 
        'writing', 
        'volume', 
        'book', 
        'date', 
        'notary', 
        'invoice', 
        'place', 
        'created_at', 
        'updated_at',
        'user_id',
        'id_user'
    ];
    protected $hidden = [
        'created_at', 
        'updated_at',
        'user_id',
        'id_user'
    ];

    public function user() {
        return $this->hasOne('App\Models\Settings\User', 'id', 'user_id');
    }
}
