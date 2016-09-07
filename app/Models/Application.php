<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    public function users(){
        return $this->belongsToMany('App\Models\User', 'user_applications');
    }
}
