<?php

namespace App\Models\Settings;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table        = 'users';
    protected $primaryKey   = 'id';
    protected $fillable = [
        'photo',
        'fullname',
        'email',
        'remember_token',
        'password',
        'pass',
        'phone',
        'address',
        'status',
        'verified',
        'created_at', 
        'updated_at',
        'file_id'
    ];

    protected $hidden = [
        'remember_token',
        'password', 
        'pass', 
        'created_at', 
        'updated_at'
    ];

    protected $appends  = [
        'url'
    ];

    protected $path = 'storage/avatars/';

    public function getUrlAttribute()
    {
        return $this->photo? asset($this->path.$this->id.'/'.$this->photo):null;
    }
    
    public function getPathAvatar()
    {
        return $this->path.$this->id.'/';
    }

    public function file() {
        return $this->hasOne('App\Models\Settings\Files');
    }
    
    public function email() {
        return $this->belongsTo('App\Models\Settings\Emails');
    }
    
    public function type() {
        return $this->belongsTo('App\Models\Settings\Types');
    }
    
    public function template() {
        return $this->belongsTo('App\Models\Settings\Templates');
    }

    public function address() {
        return $this->belongsTo('App\Models\Management\Address');
    }
    
    public function contact() {
        return $this->belongsTo('App\Models\Management\Contacts');
    }

    public function document() {
        return $this->belongsTo('App\Models\Management\Documents');
    }

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
