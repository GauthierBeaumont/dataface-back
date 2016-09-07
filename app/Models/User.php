<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'lastname','firstname','email','role_id','coordinate_id','password', 'application_id', 'applications_list'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function applications(){
        return $this->belongsToMany('App\Models\Application', 'user_applications');
    }

    public function getApplicationsListAttribute(){
        if($this->id) {
            return $this->applications()->lists('id');
        }
    }

    public function setApplicationsListAttribute($value){
        return $this->applications()->sync($value);
    }

}
