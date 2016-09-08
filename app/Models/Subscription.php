<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    public $timestamps = false;

    public function typePayment(){
      return $this->hasOne('App\Models\TypePayment','id','type_payments_id');
    }

    public function typeSubscription(){
      return $this->hasOne('App\Models\SubscriptionsTypes','id','subscriptions_types_id');
    }
    
    public function users(){
      return $this->belongsToMany('App\User','user_subscriptions')->withPivot('no_facture','date_facture');
    }
}
