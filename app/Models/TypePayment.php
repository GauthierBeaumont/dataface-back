<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TypePayment extends Model
{
    public $timestamps = false;

    public function subscriptions(){
      return $this->hasMany('App\Models\Subscription','type_payments_id','id');
    }
}
