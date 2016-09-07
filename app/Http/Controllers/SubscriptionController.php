<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Carbon\Carbon;
use App\User;
use App\Models\Subscription;
use App\Models\SubscriptionsTypes;

class SubscriptionController extends Controller
{
    //return subsciption information about an user
    public function info(User $user)
    {
        // $beginFreeTrial = Carbon::createFromFormat('Y-m-d H:i:s', $user->created_at);
        // $endFreeTrial = $beginFreeTrial->addDays(15);
        //
        // $typeSubscription = $beginFreeTrial <= $endFreeTrial ? 'Free' : 'Premium';
        //
        // $timeLeft = $typeSubscription == 'Free' ?
        //     $endFreeTrial
        //     : 0;
        $now = Carbon::now();
        $subscriptionDateValide = Carbon::createFromFormat('Y-m-d H:i:s', $user->subscription[0]->date_validation);
        //dd($now.' '.$subscriptionDateValide);
        $typeSubscription = $user->subscription[0];
        $test = json_decode($typeSubscription, true);
        array_push($test,$user->subscription[0]->typeSubscription);
        if($now->gt($subscriptionDateValide)){
          $timeLeft = 'abonnement expiré';
        }else{
            $timeLeft = $subscriptionDateValide->diff($now);
        }

        return ['type_subscription' => $typeSubscription, 'end_subscription' => $timeLeft];
    }

    private function secondsToTime($seconds)
    {
        $dtF = new \DateTime('@0');
        $dtT = new \DateTime("@$seconds");

        return $dtF->diff($dtT)->format('%a jours, %h heures, %i minutes et %s seconds');
    }
    //return all subscriptions type
    public function typeSubscriptions(){
      return SubscriptionsTypes::All();
    }
}
