<?php

namespace App\Models\Management;

use Illuminate\Database\Eloquent\Model;

class Notarials extends Model
{
    protected $table        = 'notarials';
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
}
