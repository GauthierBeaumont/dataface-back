<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Carbon\Carbon;
use App\User;

class SubscriptionController extends Controller
{
    public function info(User $user)
    {
        $beginFreeTrial = Carbon::createFromFormat('Y-m-d H:i:s', $user->created_at);
        $endFreeTrial = $beginFreeTrial->addDays(15);

        $typeSubscription = $beginFreeTrial <= $endFreeTrial ? 'Free' : 'Premium';

        $timeLeft = $typeSubscription == 'Free' ? 
            $endFreeTrial
            : 0;

        return ['type_subscription' => $typeSubscription, 'time_left' => $timeLeft];
    }

    private function secondsToTime($seconds)
    {
        $dtF = new \DateTime('@0');
        $dtT = new \DateTime("@$seconds");

        return $dtF->diff($dtT)->format('%a jours, %h heures, %i minutes et %s seconds');
    }
}