<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TypePayment extends Model
{
    public function users(){
      return $this->hasMany('App\User');
    }
}
