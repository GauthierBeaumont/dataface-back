<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubscriptionsTypes extends Model
{
    public $timestamps = false;
    public function subscriptions(){
      return $this->hasMany('App\Models\Subscription','subscriptions_types_id','id');
    }
}
