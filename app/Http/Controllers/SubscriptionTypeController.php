<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Carbon\Carbon;
use App\User;
use App\Models\Subscription;
use App\Models\SubscriptionsTypes;

class SubscriptionTypeController extends Controller
{

    //return all subscriptions type
    public function index(){

      return SubscriptionsTypes::All();
    }

    public function store(Request $request)
    {
        if($request->get('id')){
          $subscriptionsTypes = SubscriptionsTypes::findOrFail($request->get('id'));
        }else{
          $subscriptionsTypes = new SubscriptionsTypes();
        }

        $subscriptionsTypes->price = $request->get('price');
        $subscriptionsTypes->name = $request->get('name');
        $subscriptionsTypes->duration_month = $request->get('duration_month');
        $subscriptionsTypes->description = $request->get('description');
        $subscriptionsTypes->order = 1;

        return ['status' => $subscriptionsTypes->save()];

    }

    public function edit(SubscriptionsTypes $subscriptions_types)
    {
        return response()->json([
            'price' => $subscriptions_types->price,
            'name' => $subscriptions_types->name,
            'duration_month' => $subscriptions_types->duration_month,
            'description' => $subscriptions_types->description,
            'order' =>   $subscriptions_types->order
        ]);
    }

    public function destroy(SubscriptionsTypes $subscriptions_types){

      return ['status' => $subscriptions_types->delete()];
    }
}
