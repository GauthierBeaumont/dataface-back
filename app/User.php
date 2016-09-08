<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Application;

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

    public function applications() {
        return $this->belongsToMany('App\Models\Application', 'user_applications');
    }

    public function subscriptions() {
        return $this->belongsToMany('App\Models\Subscription', 'user_subscriptions');
    }

}
