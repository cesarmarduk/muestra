<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Files extends Model
{
    protected $table        = 'files';
    protected $primaryKey   = 'id';
    protected $fillable     = [
        'name', 
        'path', 
        'status',
        'created_at', 
        'updated_at'
    ];
    protected $hidden = [
        'created_at', 
        'updated_at'
    ];

    public function user() {
        return $this->belongsTo('App\Models\Settings\User');
    }
}
