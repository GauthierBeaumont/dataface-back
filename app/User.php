<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'lastname','firstname','email','role_id','coordinate_id','password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function Subscription(){
      return $this->belongsToMany('App\Models\Subscription','user_subscriptions')->withPivot('no_facture','date_facture');
    }
    
    public function coordinate(){
      return $this->hasOne('App\Models\Coordinate','id');
    }

    public function changeUserStatusBlockage() {
        $this->isBlocked = !$this->isBlocked;
        $this->save();
    }
}
