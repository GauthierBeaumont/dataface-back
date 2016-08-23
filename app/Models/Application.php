<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    public function users(){
        $this->belongsToMany('App\User');
    }
}
