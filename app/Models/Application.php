<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Application extends Model
{
	public $timestamps = false;
	
    public function users() 
    {
    	return $this->belongsToMany('App\User', 'user_applications');
    }
}
