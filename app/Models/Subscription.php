<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    public $timestamps = false;
    public function typePayment(){
      return $this->hasOne('App\Models\TypePayment');
    }
    public function typeSubscription(){
      return $this->hasOne('App\Models\SubscriptionsTypes');
    }
    public function users(){
      return $this->belongsToMany('App\User','user_subscriptions');
    }
}
