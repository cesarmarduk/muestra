<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Model;

class States extends Model
{
    protected $table        = 'states';
    protected $primaryKey   = 'id';
    protected $fillable     = [
        'name', 
        'abbreviation', 
        'status',
        'created_at', 
        'updated_at'
    ];
    protected $hidden = [
        'created_at', 
        'updated_at'
    ];

    public function city() {
        return $this->belongsTo('App\Models\Settings\Cities');
    }
}
